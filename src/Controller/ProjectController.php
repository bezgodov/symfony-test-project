<?php
namespace App\Controller;

use App\Entity\Project;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Serializer\SerializerInterface;

class ProjectController extends Controller {
    /**
     * @Route("/", name="home")
     * @Method({"GET"})
     */
    public function index() {
        $projects = $this->getDoctrine()->getRepository(Project::class)->findBy([], ['id' => 'DESC']);
        return $this->render('projects/index.html.twig', array('projects' => $projects));
    }

    /**
     * @Route("/project/edit/{id}", name="project_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $project = new Project();
        $project = $this->getDoctrine()->getRepository(Project::class)->find($id);

        $form = $this->createFormBuilder($project)
        ->add(
            'subject',
            TextType::class,
            array(
                'attr' => array(
                    'class' => 'form-control',
                ),
            )
        )
        ->add(
            'description',
            TextareaType::class,
            array(
                'required' => false,
                'attr'     => array(
                    'class' => 'form-control',
                    'rows'  => '7',
                ),
            )
        )
        ->add(
            'save',
            SubmitType::class,
            array(
                'label' => 'Update',
                'attr'  => array(
                    'class' => 'btn btn-primary mt-3',
                ),
            )
        )
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render(
            'projects/edit.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/project/delete/{id}", name="project_delete")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $project = $this->getDoctrine()->getRepository(Project::class)->find($id);

        $response = new Response();

        if ($project) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();

            $response->setStatusCode(Response::HTTP_OK);
        } else {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    /**
     * @Route("/project/parse", name="project_parse")
     * @Method({"GET", "POST"})
     */
    public function parse(Request $request, SerializerInterface $serializer) {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder()
        ->add(
            'save',
            SubmitType::class,
            array(
                'label' => 'Parse projects',
                'attr'  => array(
                    'class' => 'btn btn-primary mt-3',
                ),
            )
        )
        ->getForm();

        $form->handleRequest($request);

        $isPost = $form->isSubmitted();

        if($isPost && $form->isValid()) {
            $link = 'http://bravik.ru/dev/projects';
            $json = file_get_contents($link);
            $api = $serializer->deserialize($json, 'App\Entity\Api', 'json');

            $parsedProjects = array();

            foreach($api->getIssues() as $issue) {
                $issue = (object)$issue;
                $project = new Project();

                $projectInRep = $this->getDoctrine()->getRepository('App\Entity\Project')->find($issue->id);
                if (!$projectInRep) {
                    $project->setId($issue->id)
                        ->setPriority($issue->priority['id'])
                        ->setParent(isset($issue->parent) ? $issue->parent['id'] : null)
                        ->setSubject($issue->subject)
                        ->setDescription($issue->description)
                        ->setStartDate(new \DateTime($issue->start_date))
                        ->setDoneRatio($issue->done_ratio)
                        ->setCreatedOn(new \DateTime($issue->created_on))
                        ->setUpdatedOn(new \DateTime($issue->updated_on));
                    
                    $entityManager->persist($project);
                    $entityManager->flush();

                    $parsedProjects[] = array(
                        'id'      => $project->getId(),
                        'subject' => $project->getSubject(),
                    );
                }
            }
        }

        return $this->render(
            'projects/parse.html.twig',
            array(
                'isPost'         => $isPost,
                'parsedProjects' => $parsedProjects ?? null,
                'form'           => $form->createView(),
            )
        );
    }

    /**
     * @Route("/project/{id}", name="project_show")
     */
    public function show($id) {
        $project = $this->getDoctrine()->getRepository(Project::class)->find($id);

        return $this->render('projects/show.html.twig', array('project' => $project));
    }
}
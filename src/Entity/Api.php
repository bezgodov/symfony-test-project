<?php

namespace App\Entity;

class Api {
    private $issues;

    public function getIssues() {
        return $this->issues;
    }

    public function setIssues($issues) {
        $this->issues = $issues;

        return $this;
    }

    private $total_count;

    public function getTotalCount() {
        return $this->total_count;
    }

    public function setTotalCount($total_count) {
        $this->total_count = $total_count;

        return $this;
    }

    private $offset;

    public function getOffset() {
        return $this->offset;
    }

    public function setOffset($offset) {
        $this->offset = $offset;

        return $this;
    }

    private $limit;

    public function getLimit() {
        return $this->limit;
    }

    public function setLimit($limit) {
        $this->limit = $limit;

        return $this;
    }
} 
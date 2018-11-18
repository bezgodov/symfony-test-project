$(document).ready(function () {
    const projects = document.getElementById('projects')

    if (projects) {
        projects.addEventListener('click', (e) => {
            if(e.target.hasAttribute('data-delete-id')) {
                if(confirm('Are you sure?')) {
                    const id = e.target.getAttribute('data-delete-id')

                    fetch(`project/delete/${id}`, {
                        method: 'DELETE'
                    }).then(function() {
                        e.target.closest('tr').remove()
                    })
                    return false
                }
            }
        })
    }

    const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

    const comparer = (idx, asc) => (a, b) => ((v1, v2) => 
        v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
        )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

    document.querySelectorAll('th[data-sortable]').forEach(th => th.addEventListener('click', (() => {
        const cls = 'table-sortableItem'
        if ($(th).find('.' + cls).length > 0) {
            $(th).find('.' + cls).toggleClass(cls + '_rotated')
        } else {
            $('#projects th').find('.' + cls).each((index, el) => {
                el.remove()
            })

            $(th).append('<span class="table-sortableItem">▾</span>')
            if (this.asc) {
                $(th).find('.' + cls).toggleClass(cls + '_rotated')
            }
        }

        const table = $(th.closest('table')).children('tbody')
        Array.from(table.children('tr'))
            .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
            .forEach(tr => table.append(tr))
    })))
    
    $('#search').on('keyup', function () {
        var value = $(this).val().toLowerCase()
        var count = 0
        $('#projects tbody tr').filter(function () {
            $(this).toggle($(this).children('td[data-searchable]').text().toLowerCase().indexOf(value) > -1)
        })
    })
})
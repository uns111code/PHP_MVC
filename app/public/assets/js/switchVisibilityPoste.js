const check = document.querySelectorAll('input[data-id]');

check.forEach(input => {
    input.addEventListener('change', async(e) => {
        const {id} = e.target.dataset;  // Objet D'obturusturing
        // const id = e.target.dataset.id;

        const response = await fetch(`/admin/api/postes/${id}/switch`);

        console.log(await response.json());
        
    })
});


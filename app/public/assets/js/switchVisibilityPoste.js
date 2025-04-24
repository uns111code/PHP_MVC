const check = document.querySelectorAll('input[data-id]');

check.forEach(input => {
    input.addEventListener('change', async(e) => {
        const {id} = e.target.dataset;  // Objet D'obturusturing
        // const id = e.target.dataset.id;

        const response = await fetch(`/admin/api/postes/${id}/switch`);

        // console.log(await response.json());

        if (response.ok) {
            const data = await response.json();
            const card = e.target.closest('.card');
            const text = card.querySelector('.js-visibility-text');
            if(data.enabled) {
                // Le poste est maintenat visible
                card.classList.replace('border-danger', 'border-success');
                text.classList.replace('text-danger', 'text-success');

                text.innerHTML = `Actif`;
            } else {
                // Le poste est maintenat invisible
                card.classList.replace('border-success', 'border-danger');
                text.classList.replace('text-success', 'text-danger');

                text.innerHTML = `Inactif`;
            }
        }
        
    })
});


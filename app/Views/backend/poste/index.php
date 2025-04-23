<section class="container mt-4">
    <h1 class="text-center">Administration des postes</h1>
    <a href="/admin/postes/create" class="btn btn-primary">Créer un poste</a>
    <div
        class="mt-2 row gy-3">
        <?php foreach ($postes as $poste): ?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><?= $poste->getTitle(); ?></h2>
                    </div>
                    <div class="card-body">
                        <em class="text-muted d-block mb-3"><?= $poste->getCreatedAt()->format('Y/m/m'); ?></em>
                        <p class="card-text"><?= $poste->getDescription(); ?></p>
                        <div class="d-flex justify-content-between mt-3">
                            <a href="#" class="btn btn-warning">Modifier</a>
                            <a href="#" class="btn btn-danger">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
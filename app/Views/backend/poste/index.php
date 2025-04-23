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
                        <p class="card-text text-muted"><?= $poste->getUser()->getFullName(); ?></p>
                        <em class="text-muted d-block mb-3"><?= $poste->getCreatedAt()->format('Y/m/m'); ?></em>
                        <p class="card-text"><?= $poste->getDescription(); ?></p>
                        <div class="d-flex justify-content-between mt-3">
                            <a href="/admin/postes/<?= $poste->getId(); ?>/edit" class="btn btn-warning">Modifier</a>
                            <form action="/admin/postes/<?= $poste->getId(); ?>/delete" method="POST" onsubmit="return confirm('Etes-vous sur de vouloir supprimer ce poste ?')">
                            <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
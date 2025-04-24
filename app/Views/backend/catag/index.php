<section class="container mt-4">
    <h1 class="text-center">Administration des Catégories</h1>
    <a href="/admin/catags/create" class="btn btn-primary">Créer une Catégorie</a>
    <div
        class="mt-2 row gy-3">
        <?php foreach ($catags as $catag): ?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><?= $catag->getName(); ?></h2>
                    </div>
                    <div class="card-body">
                        <em class="text-muted d-block mb-3"><?= $catag->getCreatedAt()->format('Y/m/m'); ?></em>
                        <p class="card-text"><?= $catag->getDescription(); ?></p>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="/admin/catags/<?= $catag->getId(); ?>/edit" class="btn btn-warning">Modifier</a>
                            <form action="/admin/catags/<?= $catag->getId(); ?>/delete" method="POST" onsubmit="return confirm('Etes-vous sur de vouloir supprimer ce catag ?')">
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
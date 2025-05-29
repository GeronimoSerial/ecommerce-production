<?php
$placeholder = isset($placeholder) ? $placeholder : 'Buscar productos...';
?>
<div class="search-container mb-4">
    <form action="" method="GET" class="d-flex gap-2">
        <div class="input-group">
            <input type="text" 
                   class="form-control" 
                   placeholder="<?= $placeholder ?>" 
                   name="search"
                   value="<?= isset($_GET['search']) ? esc($_GET['search']) : '' ?>"
            >
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search me-1"></i>
                Buscar
            </button>
        </div>
    </form>
</div>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Game - Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 24px; }
        .navbar a { color: white; text-decoration: none; margin-left: 20px; }
        .container { max-width: 800px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; font-family: inherit; }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #667eea; }
        .form-group textarea { min-height: 100px; resize: vertical; }
        .form-actions { display: flex; gap: 10px; margin-top: 30px; }
        .btn { padding: 12px 30px; border-radius: 8px; text-decoration: none; font-size: 14px; border: none; cursor: pointer; transition: all 0.3s; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-secondary { background: #6b7280; color: white; }
        .btn:hover { transform: translateY(-2px); }
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input[type="checkbox"] { width: auto; }
        .current-thumbnail { max-width: 200px; border-radius: 10px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>✏️ Edit Game</h1>
        <div>
            <a href="<?php echo e(route('admin.games')); ?>">Kembali</a>
            <a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <form action="<?php echo e(route('admin.games.update', $game->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="form-group">
                    <label for="title">Nama Game *</label>
                    <input type="text" id="title" name="title" value="<?php echo e($game->title); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description"><?php echo e($game->description); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="category">Kategori</label>
                    <input type="text" id="category" name="category" value="<?php echo e($game->category); ?>">
                </div>

                <div class="form-group">
                    <label for="thumbnail">Gambar Thumbnail</label>
                    <?php if($game->thumbnail): ?>
                        <img src="<?php echo e(asset($game->thumbnail)); ?>" alt="<?php echo e($game->title); ?>" class="current-thumbnail">
                        <p style="color: #666; font-size: 12px; margin-top: 5px;">Upload gambar baru untuk mengganti</p>
                    <?php endif; ?>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                </div>

                <hr style="margin: 30px 0; border: none; border-top: 2px solid #e0e0e0;">
                
                <h3 style="color: #667eea; margin-bottom: 15px;">🎨 Custom Game Template (Opsional)</h3>
                <p style="color: #666; margin-bottom: 20px; font-size: 14px;">
                    Masukkan kode HTML lengkap dengan CSS dan JavaScript untuk custom game template. Kode ini akan dirender sebagai halaman game.
                </p>

                <div class="form-group">
                    <label for="custom_template">Complete HTML/CSS/JS Code</label>
                    <textarea id="custom_template" name="custom_template" style="font-family: 'Courier New', monospace; min-height: 400px; font-size: 13px;" placeholder="<!DOCTYPE html>
<html>
<head>
    <style>
        /* CSS di sini */
    </style>
</head>
<body>
    <div class='game-container'>
        <h2>Judul Game</h2>
    </div>
    <script>
        // JavaScript di sini
    </script>
</body>
</html>"><?php echo e($game->custom_template); ?></textarea>
                    <small style="color: #666; display: block; margin-top: 5px;">
                        💡 Masukkan kode HTML lengkap termasuk &lt;style&gt; dan &lt;script&gt; tags
                    </small>
                </div>

                <?php if($game->game_images): ?>
                    <div class="form-group">
                        <label>🖼️ Gambar yang Sudah Diupload:</label>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-top: 10px;">
                            <?php $__currentLoopData = json_decode($game->game_images); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div style="margin-bottom: 10px; padding: 10px; background: white; border-radius: 5px;">
                                    <img src="<?php echo e(asset('images/game_assets/' . $game->id . '/' . $image)); ?>" 
                                         style="max-width: 100px; max-height: 100px; border-radius: 5px; margin-right: 10px;">
                                    <code style="background: #e9ecef; padding: 5px 10px; border-radius: 3px;">
                                        /images/game_assets/<?php echo e($game->id); ?>/<?php echo e($image); ?>

                                    </code>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="game_images">📸 Upload Gambar Baru (Multiple)</label>
                    <input type="file" id="game_images" name="game_images[]" accept="image/*" multiple>
                    <small style="color: #666; display: block; margin-top: 5px;">
                        💡 Upload gambar tambahan. Gambar lama tidak akan terhapus.
                    </small>
                </div>

                <hr style="margin: 30px 0; border: none; border-top: 2px solid #e0e0e0;">

                <div class="form-group">
                    <label for="order">Urutan Tampilan</label>
                    <input type="number" id="order" name="order" value="<?php echo e($game->order); ?>" min="0">
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" <?php echo e($game->is_active ? 'checked' : ''); ?>>
                        <label for="is_active" style="margin: 0;">Aktifkan game ini</label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">💾 Update Game</button>
                    <a href="<?php echo e(route('admin.games')); ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\Game\resources\views/admin/games/edit.blade.php ENDPATH**/ ?>
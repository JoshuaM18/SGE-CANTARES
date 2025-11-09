<h2>Notificaciones</h2>

<?php if (!empty($notificaciones)): ?>
    <ul style="list-style:none; padding:0;">
        <?php foreach ($notificaciones as $notif): ?>
            <li style="margin-bottom:10px; padding:10px; border:1px solid #ccc; background:<?php echo $notif['leido'] ? '#f9f9f9' : '#e0f7fa'; ?>;">
                <strong><?php echo htmlspecialchars($notif['titulo']); ?></strong><br>
                <?php echo htmlspecialchars($notif['mensaje']); ?><br>
                <small><?php echo $notif['fecha']; ?></small><br>
                <?php if (!$notif['leido']): ?>
                    <a href="index.php?c=Notificacion&a=leer&id_notificacion=<?php echo $notif['id_notificacion']; ?>">Marcar como leída</a>
                <?php else: ?>
                    <em>Leída</em>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No hay notificaciones.</p>
<?php endif; ?>

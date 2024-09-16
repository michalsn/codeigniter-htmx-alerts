<?php foreach ($alerts as $type => $messages): ?>
    <?php foreach ($messages as $message): ?>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, <?= $message['displayTime']; ?>)" class="toast show mt-1" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <span class="bg-<?= esc($type, 'attr'); ?> avatar avatar-xs me-2"></span>
                <strong class="me-auto"><?= setting('Alerts.types')[$type] ?? ''; ?></strong>
                <button class="btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body text-muted"><?= esc($message['message']); ?></div>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>

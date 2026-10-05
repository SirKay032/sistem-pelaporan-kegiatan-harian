<?php
require __DIR__ . '/db.php';
require __DIR__ . '/functions.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isLoggedIn()) {
    redirect('index.php');
}

$currentUser = currentUser($pdo);
if (!$currentUser) {
    redirect('index.php');
}

$userId = (int) ($_GET['user_id'] ?? $currentUser['id']);
$month = (int) ($_GET['month'] ?? date('n'));
$year = (int) ($_GET['year'] ?? date('Y'));

if ($currentUser['role'] === 'pegawai' && $userId !== (int) $currentUser['id']) {
    redirect('index.php?page=rekap');
}

$html = generatePdfForUser($pdo, $userId, $month, $year);

$options = new Options();
$options->set('defaultFont', 'Helvetica');
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$filename = 'rekap-' . $userId . '-' . $month . '-' . $year . '.pdf';
$dompdf->stream($filename, ['Attachment' => true]);

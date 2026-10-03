<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$f = fopen(__DIR__ . '/scholarships.csv', 'w');
fwrite($f, "\xEF\xBB\xBF");
fputcsv($f, ['id','title','degree_level','eligible_fields','min_gpa','description']);
foreach (App\Models\Scholarship::limit(15)->get() as $i => $s) {
    fputcsv($f, [
        $i + 1,
        $s->title,
        $s->degree_level ?? '',
        $s->field_of_study ?? 'any',
        $s->min_gpa ?? '',
        str_replace(["\r","\n"], ' ', (string)($s->description ?? $s->title)),
    ]);
}
fclose($f);
echo "exported\n";

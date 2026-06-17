<?php
$directory = __DIR__ . '/resources/views/themes';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
$files = [];

foreach ($iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        // Skip partials
        if (strpos($file->getPathname(), 'partials') !== false) {
            continue;
        }
        
        $content = file_get_contents($file->getPathname());
        
        // Cek jika sudah ada
        if (strpos($content, "themes.partials.universal-sections") !== false) {
            continue;
        }

        // Cari </body> atau section penutup
        $insertStr = "\n    @include('themes.partials.universal-sections')\n";
        
        if (strpos($content, '</body>') !== false) {
            $content = str_replace('</body>', $insertStr . '</body>', $content);
        } else {
            // Append at the end if no </body>
            $content .= $insertStr;
        }
        
        file_put_contents($file->getPathname(), $content);
        echo "Updated: " . $file->getFilename() . "\n";
    }
}
echo "Done.\n";

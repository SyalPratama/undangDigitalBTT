<?php

$dir = new RecursiveDirectoryIterator('resources/views/themes');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    
    // Check if the file has name="name" and if it belongs to an RSVP form
    // Actually, name="name" is also used in the Comment form!
    // So we need to be careful. The RSVP form usually has name="status".
    // Let's check if the file has name="status"
    if (strpos($content, 'name="status"') !== false) {
        // Find the input with name="name" inside the RSVP form.
        // It's safer to just replace `<input ... name="status" ...>` or something near it.
        // Or find `name="status"` and insert the email input right BEFORE the status select/radio.
        
        // Let's use regex to find the `name="name"` input that is CLOSE to `name="status"`.
        // Better: just do a generic regex replace for RSVP form.
        // Since each theme is different, let's write a simple pattern:
        // Find the block containing name="status", find the previous name="name".
        // Actually, let's manually inspect how RSVP is built.
    }
}
echo "Done\n";

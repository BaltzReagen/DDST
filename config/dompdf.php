<?php

return array(
    'font_dir' => storage_path('fonts/'), // For custom fonts if needed
    'font_cache' => storage_path('fonts/'),
    'temp_dir' => sys_get_temp_dir(),
    'chroot' => realpath(base_path()),
    'allowed_protocols' => [
        'file://' => array('rules' => array()),
        'http://' => array('rules' => array()),
        'https://' => array('rules' => array()),
    ],
    'log_output_file' => null,
    'enable_font_subsetting' => false,
    'pdf_backend' => 'CPDF',
    'default_media_type' => 'screen',
    'default_paper_size' => 'a4',
    'default_paper_orientation' => 'portrait',
    'default_font' => 'dejavu sans',
    'dpi' => 96,
    'enable_php' => false,
    'enable_javascript' => true,
    'enable_remote' => true,
    'font_height_ratio' => 1.1,
    'enable_html5_parser' => true,
);
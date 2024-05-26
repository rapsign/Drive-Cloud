<?php

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $decimals = 2)
    {
        $size = [' B', ' KB', ' MB', ' GB', ' TB', ' PB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    if (!function_exists('shortFileType')) {
        function shortFileType($fileType)
        {
            // Daftar konversi tipe file singkat
            $fileTypeMap = [
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                'application/pdf' => 'pdf',
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                // Tambahkan tipe file lainnya di sini
                'application/vnd.ms-excel' => 'xls',
                'application/vnd.ms-powerpoint' => 'ppt',
                'application/msword' => 'doc',
                'application/zip' => 'zip',
                'text/plain' => 'txt',
                'audio/mpeg' => 'mp3',
                'video/mp4' => 'mp4',
                'application/vnd.oasis.opendocument.spreadsheet' => 'ods',
                'application/vnd.oasis.opendocument.presentation' => 'odp',
                'application/x-rar-compressed' => 'rar',
                'application/x-msdownload' => 'exe',
                'application/octet-stream' => 'bin',
                'application/vnd.android.package-archive' => 'apk',
                'application/x-tar' => 'tar',
                'application/x-bzip' => 'bz',
                'application/x-bzip2' => 'bz2',
                'application/x-gzip' => 'gz',
                'application/x-7z-compressed' => '7z',
                'application/x-tex' => 'tex',
                'application/x-sh' => 'sh',
                'application/x-php' => 'php',
                'application/javascript' => 'js',
                'text/html' => 'html',
                'image/gif' => 'gif',
                'image/bmp' => 'bmp',
                'image/webp' => 'webp',
                'audio/wav' => 'wav',
                'audio/ogg' => 'ogg',
                'video/ogg' => 'ogv',
                'video/webm' => 'webm',
                'application/x-msmetafile' => 'wmf',
                'application/postscript' => 'ps',
                'application/x-dvi' => 'dvi',
                'application/x-font-ttf' => 'ttf',
                'application/vnd.visio' => 'vsd',
                'application/x-ms-wmd' => 'wmd',
                'application/vnd.ms-wpl' => 'wpl',
                'application/vnd.ms-xpsdocument' => 'xps',
                'application/vnd.oasis.opendocument.text' => 'odt',
                'application/vnd.oasis.opendocument.graphics' => 'odg',
                'application/vnd.oasis.opendocument.text-master' => 'odm',
                'application/vnd.oasis.opendocument.text-template' => 'ott',
                'application/vnd.oasis.opendocument.image' => 'odi',
                'application/vnd.oasis.opendocument.text-web' => 'oth',
                'application/vnd.oasis.opendocument.spreadsheet-template' => 'ots',
                'application/vnd.oasis.opendocument.presentation-template' => 'otp',
                'application/vnd.oasis.opendocument.chart' => 'odc',
                'application/vnd.oasis.opendocument.formula' => 'odf',
                'application/vnd.oasis.opendocument.graphics-template' => 'otg',
                'application/vnd.oasis.opendocument.chart-template' => 'otc',
                'application/vnd.oasis.opendocument.database' => 'odb',
                'application/vnd.oasis.opendocument.formula-template' => 'odft',
                'application/x-debian-package' => 'deb',
                'application/x-font-woff' => 'woff',
                'application/x-java-archive' => 'jar',
                'application/x-ms-shortcut' => 'lnk',
                'application/x-ole-storage' => 'ole',
                'application/x-perl' => 'pl',
                'application/x-python' => 'py',
                'application/x-shellscript' => 'sh',
                'application/x-tar' => 'tar',
                'application/x-zip' => 'zip',
                'application/xhtml+xml' => 'xhtml',
                'application/xml' => 'xml',
                'application/x-rar' => 'rar',
                'application/x-gzip' => 'gz',
                'application/x-bzip2' => 'bz2',
                'application/x-7z-compressed' => '7z',
                'application/x-msdownload' => 'exe',
                'application/x-apple-diskimage' => 'dmg',
                'audio/basic' => 'au',
                'audio/midi' => 'mid',
                'audio/mpeg' => 'mp3',
                'audio/x-aiff' => 'aif',
                'audio/x-wav' => 'wav',
                'image/bmp' => 'bmp',
                'image/gif' => 'gif',
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/tiff' => 'tiff',
                'image/vnd.microsoft.icon' => 'ico',
                'audio/x-ms-wma' => 'wma',
                'audio/vnd.rn-realaudio' => 'ra',
                'audio/aac' => 'aac',
                'audio/x-matroska' => 'mka',
                'audio/vnd.wave' => 'wav',
                'audio/vnd.dts' => 'dts',
                'audio/vnd.dts.hd' => 'dtshd',
                'audio/x-ms-wax' => 'wax',
                'audio/x-pn-realaudio' => 'rm',
                'audio/x-pn-realaudio-plugin' => 'rpm',
                'audio/x-wav' => 'wav',
                'image/x-ms-bmp' => 'bmp',
                'image/tiff' => 'tiff',
                'image/x-icon' => 'ico',
                'image/webp' => 'webp',
                'video/x-ms-asf' => 'asf',
                'video/x-ms-wmx' => 'wmx',
                'video/x-ms-wvx' => 'wvx',
                'video/x-ms-wm' => 'wm',
                'video/x-ms-wmp' => 'wmp',
                'video/x-ms-wmv' => 'wmv',
                'video/x-ms-wmz' => 'wmz',
                'video/x-ms-wvx' => 'wvx',
                'video/3gpp' => '3gp',
                'video/3gpp2' => '3g2',
                'video/mp4' => 'mp4',
                'video/mpeg' => 'mpeg',
                'video/ogg' => 'ogg',
                'video/quicktime' => 'mov',
                'video/vnd.dlna.mpeg-tts' => 'm2t',
                'video/vnd.dlna.mpeg-tts' => 'm2ts',
                'video/x-flv' => 'flv',
                'video/x-m4v' => 'm4v',
                'video/x-matroska' => 'mkv',
                'video/x-msvideo' => 'avi',
                'video/x-sgi-movie' => 'movie',
                'application/vnd.apple.keynote' => 'keynote',
                'application/vnd.apple.pages' => 'pages',
                'application/vnd.apple.numbers' => 'numbers',
                'application/x-tar' => 'tar',
                'application/x-7z-compressed' => '7z',
                'application/x-xz' => 'xz',
                'application/x-rar-compressed' => 'rar',
                'application/x-bzip2' => 'bz2',
                'application/x-gzip' => 'gz',
                'application/x-stuffit' => 'sit',
                'application/x-dvi' => 'dvi',
                'application/x-shockwave-flash' => 'swf',
                'application/x-msmetafile' => 'wmf',
                'application/x-xpinstall' => 'xpi',
                'application/x-compressed' => 'zip',
                'application/x-gtar' => 'gtar',
                'application/x-tar' => 'tar',
                'application/x-gzip' => 'gzip',
                'application/x-bzip2' => 'bzip2',
                'application/x-bzip' => 'bzip',
                'application/x-zip-compressed' => 'zip',
                'application/x-compress' => 'compress',
                'application/x-lha' => 'lha',
                'application/x-lzh' => 'lzh',
                'application/octet-stream' => 'bin',
                'application/zip' => 'zip',
                'application/x-troff-msvideo' => 'avi',
                'application/vnd.ms-excel' => 'xls',
                'application/vnd.ms-powerpoint' => 'ppt',
                'application/vnd.ms-word' => 'doc',
                'application/x-dvi' => 'dvi',
                'application/x-shockwave-flash' => 'swf',
                'application/x-tar' => 'tar',
                'application/x-gzip' => 'gz',
                'application/x-bzip2' => 'bz2',
                'application/x-bzip' => 'bz',
                'application/x-zip-compressed' => 'zip',
                'application/x-7z-compressed' => '7z',
                'application/x-rar-compressed' => 'rar',
                'application/x-gtar' => 'gtar',
                'application/x-gzip' => 'gzip',
                'application/x-bzip2' => 'bzip2',
                'application/x-bzip' => 'bzip',
                'application/x-zip-compressed' => 'zip',
                'application/x-compress' => 'compress',
                'application/x-lha' => 'lha',
                'application/x-lzh' => 'lzh',
                'application/octet-stream' => 'bin',
                'application/vnd.apple.installer+xml' => 'mpkg',
                'application/vnd.debian.binary-package' => 'deb',
                'application/vnd.rar' => 'rar',
                'application/x-iso9660-image' => 'iso',
                'application/x-msdownload' => 'exe',
                'application/x-msi' => 'msi',
                'application/x-nrg' => 'nrg',
                'application/x-sh' => 'sh',
                'application/x-iso9660-image' => 'iso',
                'application/x-msdownload' => 'exe',
                'application/x-msi' => 'msi',
                'application/x-nrg' => 'nrg',
                'application/x-sh' => 'sh',
                'application/x-7z-compressed' => '7z',
                'application/x-bzip' => 'bz',
                'application/x-bzip2' => 'bz2',
                'application/x-gtar' => 'gtar',
                'application/x-gzip' => 'gzip',
                'application/x-rar-compressed' => 'rar',
                'application/x-tar' => 'tar',
                'application/x-zip-compressed' => 'zip',
                'application/x-compressed' => 'zip',
                'application/x-zip' => 'zip',
                'application/x-gtar' => 'gtar',
                'application/x-tar' => 'tar',
                'application/x-gzip' => 'gzip',
                'application/x-bzip2' => 'bz2',
                'application/x-bzip' => 'bz',
                'application/x-zip-compressed' => 'zip',
                'application/x-compress' => 'compress',
                'application/x-lha' => 'lha',
                'application/x-lzh' => 'lzh',
                'application/x-dvi' => 'dvi',
                'application/x-shockwave-flash' => 'swf',
                'application/x-msmetafile' => 'wmf',
                'application/x-xpinstall' => 'xpi',
                'application/x-iso9660-image' => 'iso',
                'application/x-nrg' => 'nrg',
                'application/x-sh' => 'sh',
                'application/x-7z-compressed' => '7z',
                'application/x-bzip' => 'bz',
                'application/x-bzip2' => 'bz2',
                'application/x-gtar' => 'gtar',
                'application/x-gzip' => 'gzip',
                'application/x-rar-compressed' => 'rar',
                'application/x-tar' => 'tar',
                'application/x-zip-compressed' => 'zip',
                'application/x-compressed' => 'zip',
                'application/x-zip' => 'zip',
                'application/x-gtar' => 'gtar',
                'application/x-tar' => 'tar',
                'application/x-gzip' => 'gzip',
                'application/x-bzip2' => 'bz2',
                'application/x-bzip' => 'bz',
                'application/x-zip-compressed' => 'zip',
                'application/x-compress' => 'compress',
                'application/x-lha' => 'lha',
                'application/x-lzh' => 'lzh',
                'application/octet-stream' => 'bin',
            ];

            // Cek apakah tipe file ada dalam daftar konversi
            return $fileTypeMap[$fileType] ?? $fileType;
        }
    }
}

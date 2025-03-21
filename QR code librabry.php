<?php
// Check if Composer autoloader exists
if (!file_exists('vendor/autoload.php')) {
    die("Error: vendor/autoload.php not found. Please run 'composer require bacon/bacon-qr-code'");
}

require_once 'vendor/autoload.php';

// Import all necessary classes at the top level
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

try {
    // Check if we should use Imagick or GD
    if (extension_loaded('imagick')) {
        // Use Imagick backend
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
    } else {
        // Fallback to GD if Imagick is not available
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );
        echo "Note: Using SVG backend as Imagick is not available.\n";
    }

    $writer = new Writer($renderer);
    $qrContent = 'Hello World!';
    $outputFile = 'qrcode.svg';
    
    // Generate the QR code
    $writer->writeFile($qrContent, $outputFile);
    
    echo "QR Code successfully generated at: $outputFile";
} catch (Exception $e) {
    echo "Error generating QR code: " . $e->getMessage();
}
?>
//composer require bacon/bacon-qr-code



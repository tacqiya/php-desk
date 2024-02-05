<?php
// Load the SVG file
$svgFilePath = 'path/input.svg';
$svgContent = file_get_contents($svgFilePath);

// Create an Imagick object and set the SVG content
$imagick = new Imagick();
$imagick->readImageBlob($svgContent);

// Set the image format for the output (e.g., PNG, JPEG)
$outputFormat = 'png'; // You can change this to your desired image format

// Optionally, you can adjust the image properties as needed
$imagick->setImageFormat($outputFormat);
$imagick->setImageBackgroundColor(new ImagickPixel('white')); // Set background color if needed
$imagick->setResolution(300, 300); // Set resolution (dots per inch)

// Perform the conversion
$imagick->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE); // Remove alpha channel if present
$imagick->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN); // Flatten the image

// Save the converted image to a file
$outputFilePath = 'path/output.' . $outputFormat;
$imagick->writeImage($outputFilePath);

// Clean up resources
$imagick->clear();
$imagick->destroy();

echo "Conversion completed. The image has been saved to: $outputFilePath";
?>
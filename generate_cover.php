<?php
// generate_cover.php
function generateMemoireCover($title, $subtitle, $theme, $outputPath) {
    try {
        $imagick = new Imagick();
        $imagick->newImage(1200, 1700, new ImagickPixel('#ffffff')); 
        $imagick->setResolution(300, 300);
        
        $draw = new ImagickDraw();
        $draw->setFont('fonts/times.ttf');
        
        // العنوان الرئيسي
        $draw->setFontSize(48);
        $draw->setFillColor('#000080');
        $draw->setFontWeight(800);
        $imagick->annotateImage($draw, 100, 200, 0, $title);
        
        // الخط الفاصل
        $draw->setStrokeColor('#000080');
        $draw->setStrokeWidth(3);
        $draw->line(100, 230, 1100, 230);
        
        // التفاصيل
        $draw->setFontSize(36);
        $draw->setFontWeight(600);
        $imagick->annotateImage($draw, 100, 350, 0, $subtitle);
        $imagick->annotateImage($draw, 100, 450, 0, 'THÈME:');
        $imagick->annotateImage($draw, 100, 550, 0, $theme);
        
        // الحفظ
        $imagick->setImageFormat('png');
        $imagick->setImageCompressionQuality(100);
        $imagick->writeImage($outputPath);
        
        return $outputPath;
    } catch (Exception $e) {
        error_log("Error generating cover: " . $e->getMessage());
        return false;
    }
}
?>
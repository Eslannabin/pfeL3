<?php
class PDFPreviewGenerator {
    const GHOSTSCRIPT_PATH = '"C:\\Program Files\\gs\\gs10.05.0\\bin\\gswin64c.exe"';
    
    public static function createPreview($pdfPath, $outputDir) {
        if (!file_exists($pdfPath)) {
            error_log("Fichier PDF introuvable : $pdfPath");
            return null;
        }

        if (!is_dir($outputDir) && !mkdir($outputDir, 0755, true)) {
            error_log("Échec création dossier : $outputDir");
            return null;
        }

        $outputFile = $outputDir . 'preview_' . md5(basename($pdfPath)) . '.jpg';

        if (file_exists($outputFile)) {
            return $outputFile;
        }

        $command = sprintf(
            '%s -dQUIET -dNOPAUSE -sDEVICE=jpeg -dJPEGQ=95 -r300 -dFirstPage=1 -dLastPage=1 '.
            '-dColorConversionStrategy=/sRGB -dProcessColorModel=/DeviceRGB '.
            '-dPDFFitPage=true -dDEVICEWIDTHPOINTS=1200 -dDEVICEHEIGHTPOINTS=1700 '.
            '-sOutputFile="%s" "%s" -c quit',
            self::GHOSTSCRIPT_PATH,
            $outputFile,
            $pdfPath
        );

        exec($command, $output, $returnCode);

        if ($returnCode === 0 && file_exists($outputFile)) {
            try {
                $img = new Imagick($outputFile);
                
                // تحسينات إضافية للجودة
                $img->setImageResolution(300, 300);
                $img->resampleImage(300, 300, Imagick::FILTER_LANCZOS, 1);
                $img->unsharpMaskImage(0.5, 1, 1, 0.05);
                $img->setImageCompressionQuality(95);
                
                $img->writeImage($outputFile);
                $img->destroy();
                return $outputFile;
            } catch (Exception $e) {
                error_log("Optimisation image échouée: ".$e->getMessage());
                return $outputFile;
            }
        }
    }

       
    }
?>
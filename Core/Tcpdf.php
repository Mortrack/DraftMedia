<?php

namespace Core;

use App\Models\HackAttempts;

/**
 * This class purpose is to provide complementary tools to work with TCPDF component
 *
 * Class Ddos
 * @package Core
 *
 * @author Miranda Meza César
 * DATE November 19, 2018
 */
class Tcpdf extends \TCPDF
{

    /**
     * This method is in charge of allowing us to set a desired watermark image to a pdf that we
     * worked with TCPDF component.
     *
     * @param string $imageDir
     *
     * @author Miranda Meza César
     * DATE November 19, 2018
     */
    public function Header()
    {
        // Get the current page break margin
        $bMargin = $this->getBreakMargin();

        // Get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;

        // Disable auto-page-break
        $this->SetAutoPageBreak(false, 0);

        // Define the path to the image that you want to use as watermark.
        $img_file = dirname(dirname(__FILE__)) . '/public/img/Invoice/bg-paid-op50.png';

        // Render the image
        $this->Image($img_file, 50, 100, 100, 90, '', '', '', false, 300, '', false, false, 0);

        // Restore the auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        // Set the starting point for the page content
        $this->setPageMark();
    }
}

<?php

/**
 * CodeIgniter DomPDF Library
 *
 * Generate PDF's from HTML in CodeIgniter
 *
 * @packge        CodeIgniter
 * @subpackage        Libraries
 * @category        Libraries
 * @author        Ardianta Pargo
 * @license        MIT License
 * @link        https://github.com/ardianta/codeigniter-dompdf
 */

namespace App\Libraries;

use Dompdf\Dompdf;

class Pdf extends Dompdf
{
  /**
   * PDF filename
   * @var String
   */
  public $filename;
  public function __construct()
  {
    parent::__construct();
    $this->filename = "laporan.pdf";
  }

  /**
   * Load a CodeIgniter view into domPDF
   *
   * @access    public
   * @param    string    $view The view to load
   * @param    array    $data The view data
   * @return    void
   */
  public function loadView($view, $data = array())
  {
    $html = view($view, $data);
    $this->loadHtml($html);
    // Render the PDF
    $this->render();
    // Output the generated PDF to Browser
    $this->stream($this->filename, array("Attachment" => false));
  }
}

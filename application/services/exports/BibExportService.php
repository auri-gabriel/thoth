<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * BibExportService
 *
 * Generates a BibTeX (.bib) file string from an array of paper objects.
 * Handles escaping of special LaTeX characters in all relevant fields.
 *
 * Usage:
 *   $service = new BibExportService();
 *   echo $service->generate($papers);
 */
class BibExportService
{
    /**
     * Characters that need to be replaced with LaTeX-safe equivalents
     * in BibTeX field values.
     */
    private const LATEX_CHAR_MAP = [
        'À' => "\'{A}", 'Á' => "\'{A}", 'Â' => "\\^{A}", 'Ã' => "\\~{A}",
        'Ä' => "\\\"{A}", 'Å' => "\\AA",
        'à' => "\'{a}", 'á' => "\'{a}", 'â' => "\\^{a}", 'ã' => "\\~{a}",
        'ä' => "\\\"{a}", 'å' => "\\aa",
        'Æ' => "\\ae", 'æ' => "\\ae",
        'È' => "\'{E}", 'É' => "\'{E}", 'Ê' => "\\^{E}", 'Ë' => "\\\"{E}",
        'è' => "\'{e}", 'é' => "\'{e}", 'ê' => "\\^{e}", 'ë' => "\\\"{e}",
        'Ì' => "\'{I}", 'Í' => "\'{I}", 'Î' => "\\^{I}", 'Ï' => "\\\"{I}",
        'ì' => "\'{i}", 'í' => "\'{i}", 'î' => "\\^{i}", 'ï' => "\\\"{i}",
        'Ñ' => "\\~{N}", 'ñ' => "\\~{n}",
        'Ò' => "\'{O}", 'Ó' => "\'{O}", 'Ô' => "\\^{O}", 'Õ' => "\\~{O}",
        'Ö' => "\\\"{O}",
        'ò' => "\'{o}", 'ó' => "\'{o}", 'ô' => "\\^{o}", 'õ' => "\\~{o}",
        'ö' => "\\\"{o}",
        'Ù' => "\'{U}", 'Ú' => "\'{U}", 'Û' => "\\^{U}", 'Ü' => "\\\"{U}",
        'ù' => "\'{u}", 'ú' => "\'{u}", 'û' => "\\^{u}", 'ü' => "\\\"{u}",
        'Ý' => "\'{Y}", 'ý' => "\'{Y}", 'ÿ' => "\\\"{y}",
        'Ŕ' => "\'{R}", 'ŕ' => "\'{ŕ}",
        'Ç' => "\\c{C}", 'ç' => "\\c{C}",
        '!'  => "!'",  '?'  => "?'",
        '$'  => "\\$", '#'  => "\\#", '%'  => "\\%", '&'  => "\\&",
        '}'  => "\\}", '{'  => "\\{",
        '\\' => "\$\\backslash\$",
        '_'  => "\\_",
    ];

    /**
     * Fields on the paper object that require LaTeX escaping,
     * mapped to their getter/setter method suffixes.
     */
    private const ESCAPABLE_FIELDS = [
        'title', 'author', 'journal', 'address', 'location', 'book_title', 'publisher',
    ];

    /**
     * Generate a BibTeX string for the given array of paper objects.
     *
     * @param  object[] $papers
     * @return string
     */
    public function generate(array $papers): string
    {
        $papers = array_map([$this, 'escape_paper_fields'], $papers);

        $out = '';
        foreach ($papers as $paper) {
            $out .= $this->build_entry($paper);
        }

        return $out;
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Escape all LaTeX-sensitive characters in a paper's text fields.
     */
    private function escape_paper_fields($paper)
    {
        foreach (self::ESCAPABLE_FIELDS as $field) {
            $getter = 'get_' . $field;
            $setter = 'set_' . $field;
            $paper->$setter(strtr($paper->$getter(), self::LATEX_CHAR_MAP));
        }

        return $paper;
    }

    /**
     * Build a single BibTeX entry string for one paper.
     */
    private function build_entry($paper): string
    {
        $out  = '@' . $paper->get_type() . '{' . $paper->get_id() . ",\n";
        $out .= 'title={'      . $paper->get_title()      . "},\n";
        $out .= 'author={'     . $paper->get_author()     . "},\n";
        $out .= 'keywords={'   . $paper->get_keywords()   . "},\n";
        $out .= 'volume={'     . $paper->get_volume()     . "},\n";
        $out .= 'year={'       . $paper->get_year()       . "},\n";
        $out .= 'publisher={'  . $paper->get_publisher()  . "},\n";
        $out .= 'journal={'    . $paper->get_journal()    . "},\n";
        $out .= 'booktitle={'  . $paper->get_book_title() . "},\n";
        $out .= 'doi={'        . $paper->get_doi()        . "},\n";
        $out .= 'pages={'      . $paper->get_pages()      . "},\n";
        $out .= 'numpages={'   . $paper->get_num_pages()  . "},\n";
        $out .= 'issn={'       . $paper->get_issn()       . "},\n";
        $out .= 'isbn={'       . $paper->get_isbn()       . "},\n";
        $out .= 'url={'        . $paper->get_url()        . "},\n";
        $out .= 'location={'   . $paper->get_location()   . "},\n";
        $out .= 'address={'    . $paper->get_address()    . "},\n";
        $out .= "}\n\n";

        return $out;
    }
}

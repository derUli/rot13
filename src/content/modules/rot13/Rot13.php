<?php

class Rot13 extends Controller
{

    private $moduleName = "rot13";

    public function getSettingsHeadline()
    {
        return "ROT13";
    }

    public function getSettingsLinkText()
    {
        return get_translation("open");
    }

    public function settings()
    {
        if (! is_null(Request::getVar("text"))) {
            ViewBag::set("result", str_rot13(Request::getVar("text")));
        }
        return Template::executeModuleTemplate($this->moduleName, "form");
    }

    public function frontendFooter()
    {
        echo Template::executeModuleTemplate($this->moduleName, "footer");
    }

    public function adminFooter()
    {
        $this->frontendFooter();
    }

    public function contentFilter($html)
    {
        preg_match_all("/\[rot13](.+)\[\/rot13]/", $html, $match);
        
        if (count($match) > 0) {
            for ($i = 0; $i < count($match[0]); $i ++) {
                $placeholder = $match[0][$i];
                $value = unhtmlspecialchars($match[1][$i]);
                $value = str_rot13($value);
                $newHtml = "<div class=\"rot13\">$value</div>";
                $html = str_replace($placeholder, $newHtml, $html);
            }
        }
        return $html;
    }
}
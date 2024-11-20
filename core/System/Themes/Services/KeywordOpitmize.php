<?php
namespace Vsw\Themes\Services;
use Core\Services\SeoAnalysis;
use AdminFunc;

class KeywordOpitmize extends SeoAnalysis
{
    /**
     * @var
     */
    protected $keyword;

    protected $textcontent;
    /**
     * @var array
     */
    protected $good = [];

    /**
     * @var array
     */
    protected $warnings = [];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * KeywordAnalysis constructor.
     * @param $url
     * @param $keyword
     * @param bool $size
     */
    public function __construct($url, $keyword,$description,$content, $size = false)
    {
        parent::__construct($url);
        $this->keyword = $keyword;
        $this->description = $description;
        $this->content = $content;
        $this->fetchBasic($size);

        if ($content) {
            $this->textcontent = @new \DOMDocument('1.0', 'UTF-8');
            libxml_use_internal_errors(true);
            $this->textcontent->loadHTML($content);
            libxml_clear_errors();
        }
    }

    /**
     * @param bool $size
     * @return $this
     */
    public function fetchBasic($size = false)
    {
        $this->data['title'] = $this->title();
        $this->data['metas'] = $this->metaTags();
        $this->data['headings'] = $this->headings();
        $this->data['images'] = $this->images($size);
        $this->data['anchors'] = $this->anchor();
        return $this;
    }
    /**
     *
     */
    public function density()
    {
        $keywordWord = str_word_count($this->keyword);
        // $pageWord = str_word_count($this->textContent());
        $content = preg_replace('/^[ \t]*[\r\n]+/m', '', strip_tags($this->content));
        $pageWord = str_word_count($content);
        if ($pageWord > 0) {
            return round(($keywordWord / $pageWord) * 100, 2);
        }
        return '';
    }

    /**
     * @return $this
     */
    public function inTitle()
    {

        $matches = $this->find($this->data['title']);
        if ($matches > 0) {
            $this->good[] = 'Keyword found in title';
        } else {
            $this->errors[] = 'Keyword is not found on title';
        }
        return $this;

    }
    public function startTitle(){
        return $this->findstart($this->data['title'],$this->keyword,'title');
    }
    public function startSlug(){
        $slug = AdminFunc::getslugtext($this->data['title']);
        $keyword = AdminFunc::getslugtext($this->keyword);
        return $this->findstart($slug,$keyword,'slug');
    }

    public function inSlug(){
        $matches = $this->findslug( AdminFunc::getslugtext($this->data['title']));
        if ($matches > 0) {
            $this->good[] = 'Keyword found in slug';
        } else {
            $this->errors[] = 'Keyword is not found on slug';
        }
        return $this;
    }

    public function OutboundLinks(){
        $domain =[preg_replace("#^[^:/.]*[:/]+#i", '', strip_tags($this->getDomain()))];
        $countlink = count(array_diff($this->checklinkcontent(),$domain));
        if ($countlink > 0) {
            $this->good[] = 'Có '.$countlink.' liên kết ra ngoài, rất tốt!';
        } else {
            $this->errors[] = 'No outbound links appear in this page. Add some!';
        }
        return $this;
    }
    public function InternalLinks(){
        $domain =[preg_replace("#^[^:/.]*[:/]+#i", '', strip_tags($this->getDomain()))];
        $checklink = $this->checklinkcontent();
        if ($checklink && in_array($domain, $checklink)) {
            $this->good[] = 'There are both nofollowed and normal internal links on this page. Good job!';
        } else {
            $this->errors[] = 'No internal links appear in this page, make sure to add some!';
        }
        return $this;
    }

    public function checklinkcontent(){
        $ahrefs = $this->textcontent->getElementsByTagName('a');
        $data = [];
        foreach ($ahrefs as $key => $taba) {
            $href = '';
            foreach ($taba->attributes as $attr) {
                $href = preg_replace("#^[^:/.]*[:/]+#i", '', strip_tags($attr->nodeValue));
            }
            $data[] = $href;
        }
        return $data;
    }

    /**
     * @return $this
     */
    public function run()
    {
        $this->inTitle()
        ->startTitle()
        ->inSlug()
        ->startSlug()
        ->inDescription()
        ->startDescription()
        ->lengthDescription()
        ->lengthTextContent()
        ->inHeadings()
        ->inImageAlt()
        ->inFirstPara()
        ->OutboundLinks()
        ->InternalLinks()
        ->density();
        return $this;
    }

    /**
     * @return $this
     */
    public function inDescription()
    {
        if ($this->description) {
            $matches = $this->find($this->description);
            if ($matches > 0) {
                $this->good[] = 'Keyword found in meta description';
            } else {
                $this->errors[] = 'Keyword is not found on meta description';
            }
        } else {
            $this->errors[] = 'No meta description found';
        }
        return $this;
    }

    public function startDescription(){
        return $this->findstart($this->description,$this->keyword,'description');
    }

    public function lengthDescription(){
        if (mb_strlen($this->description) > 120 && mb_strlen($this->description) < 156) {
            $this->good[] = 'The meta description is greater than 120 and less than 156 characters. Very good!';
        } else {
            $this->warnings[] = 'The meta description is over 156 characters. To ensure the entire description will be visible, you should reduce the length!';
        }
        return $this;
    }
    public function lengthTextContent(){
        $content = preg_replace('/^[ \t]*[\r\n]+/m', '', strip_tags($this->content));
        $lengthtext = mb_strlen($content);
        if ($lengthtext > 300) {
            $this->good[] = 'The text contains '.$lengthtext.' words. Good job!';
        } else {
            $this->warnings[] = 'The text contains '.$lengthtext.' word. This is far below the recommended minimum of 300 words. Add more content.';
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function inHeadings()
    {
        $h1 = isset($this->data['headings']['h1']) ? $this->data['headings']['h1'] : [];
        if (is_array($h1) && count($h1) > 0) {
            $matches = $this->find(array_shift($h1));
            if ($matches > 0) {
                $this->good[] = 'Keyword found on h1 tag';
            } else {
                $this->errors[] = 'Keyword not found on h1 tag';
            }
        } else {
            $this->warnings[] = 'No h1 tag found in this page';
        }
        $h2 = isset($this->data['headings']['h2']) ? $this->data['headings']['h2'] : [];
        $h2Found = 0;

        foreach ($h2 as $text) {
            $matches = $this->find($text);
            if ($matches > 0) {
                $h2Found++;
            }
        }
        if (count($h2) > 0 && $h2Found > 0) {
            $this->good[] = 'Keyword found on h2 tag';
        }

        $h3 = isset($this->data['headings']['h3']) ? $this->data['headings']['h3'] : [];
        $h3Found = 0;

        foreach ($h3 as $text) {
            $matches = $this->find($text);
            if ($matches > 0) {
                $h3Found++;
            }
        }
        if (count($h3) > 0 && $h3Found > 0) {
            $this->good[] = 'Keyword found on h3 tag';
        } else {
            $this->warnings[] = 'Keyword does not found any of h3 tag';
        }

        return $this;
    }

    /**
     *
     */
    public function inImageAlt()
    {
        $images = $this->data['images'];
        $found = 0;
        $altArr = array_column($images, 'alt');
        $tabimgArr = array_diff(array_column($images, 'imgemptyalt'),['']);

        foreach ($altArr as $alt) {
            $matches = $this->find($alt);
            if ($matches > 0) {
                $found++;
            }
        }
        if (count($altArr) > 0 && count($tabimgArr) > 0) {
            $this->good[] = 'Found in alt tag';
        } elseif (count($altArr) > 0) {
            $this->warnings[] = 'Its good to have foucus keyword on one of image alt tag but none found';
        }
        if ((count($altArr) > 0 && count($tabimgArr) > 0) && (count($tabimgArr) < count($images))) {
            $messenger = count($tabimgArr) . ' alt attribute missing from image'."\n";
            $messenger .= '<pre class="text-danger">';
            foreach ($tabimgArr as $key => $image) {
                $messenger .= $image."\n";
            }
            $messenger .= '</pre>';
            $this->warnings[] = $messenger;
        }
        return $this;

    }

    /**
     *
     */
    public function inFirstPara()
    {
        return $this;
    }

    /**
     * @param $string
     * @return int
     */
    public function find($string)
    {
        preg_match_all('/(' . $this->keyword . ')/i', $string, $matches, PREG_SET_ORDER);
        return count($matches);
    }

    public function findslug($slug)
    {
        preg_match_all('/(' . AdminFunc::getslugtext($this->keyword) . ')/i', $slug, $matches, PREG_SET_ORDER);
        return count($matches);
    }

    public function findstart($string,$keyword,$type){
        if (strpos($string,$keyword)==0) {
            $this->good[] = 'The exact match of the keyphrase appears at the beginning of the SEO '.$type.'. Good job!';
        } else {
            $this->warnings[] = 'The exact match of the keyphrase appears in the SEO '.$type.', but not at the beginning. Try to move it to the beginning.';
        }
        return $this;
    }

    public function result()
    {
        return [
            'good' => $this->good,
            'warnings' => $this->warnings,
            'errors' => $this->errors,

        ];
    }

}
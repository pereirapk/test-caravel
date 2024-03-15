<?php
declare(strict_types=1);

namespace Caravel\Author\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Theme\Block\Html\Title;
use Magento\Framework\App\RequestInterface;
use Magento\Cms\Model\PageFactory;

class Page
{
    
    const AUTHOR_PATH = 'section_id/general/author';
    private $scopeConfig;
    private $request;
    private $pageFactory;
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        RequestInterface $request,
        PageFactory $pageFactory,
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
        $this->pageFactory = $pageFactory;
    }

    public function afterGetTitle(Title $subject, $result)
    {
        $pageId = $this->request->getParam('page_id');
        $author = $this->pageFactory->create()->load($pageId)->getAuthor();
        if($this->getScopeConfig() && !empty($author)){
            $result .= '<br> Author: '. $author;
        }
        return $result;
    }
    public function getScopeConfig()
    {
       return (bool)$this->scopeConfig->getValue(self::AUTHOR_PATH);
    }
}
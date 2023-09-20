<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!\Bitrix\Main\Loader::includeModule('silab.sitecore'))
{
    die();
}

use Silab\SiteCore\Interfaces\SearchServiceInterface;
use Bitrix\Main\Engine\Contract\Controllerable; 
use Bitrix\Main\Errorable;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Error;
use Bitrix\Main\DI\ServiceLocator;        

class SearchComponent extends \CBitrixComponent  implements Controllerable, Errorable
{   
    protected ErrorCollection $errorCollection;
    
    /**
     * @param type $component
     */
    public function __construct($component = null)
    {
        parent::__construct($component);
        
        $this->errorCollection = new ErrorCollection();
    }

    /**
     * Get errors
     * 
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errorCollection->toArray();
    }
    
    /**
     * Get error by code
     * 
     * @param type $code
     * @return Error
     */
    public function getErrorByCode($code): Error
    {
        return $this->errorCollection->getErrorByCode($code);
    }
    
    /**
     * Set config actions 
     * 
     * @return array
     */
    public function configureActions()
    {
        return [
            'query' => [
                'prefilters' => []
            ]
        ];
    }

    /**
     * Query search 
     * 
     * @param string $query
     * @return array
     */
    public function queryAction(string $query, int $page = 1, int $count = 10): array
    {
        try 
        {     
            $params = [];
            
            $service = $this->getService();
            
            $params['size'] = $count;
            
            $params['page'] = $page;
            
            $result = $service->search($query, $params);
            
            return $this->getAnswer([
                'categories' => $result->categories,
                'products' => $result->products,
                'pages' => $result->pages,
            ]);
        } 
        catch (Exception $e)
        {
            $this->errorCollection[] = new Error($e->getMessage());
            
            return $this->getAnswer('Произошла ошибка');
        }
    }
    
    /**
     * Ansver result  
     * 
     * @param mixed $response
     * @return array
     */
    private function getAnswer($response) : array
    {
        return [
            "result" => $response,
        ];
    }

    /**
     * get search service
     * 
     * @return SearchServiceInterface
     * @throws Exception
     */
    private function getService() : SearchServiceInterface
    {
        $serviceLocator = ServiceLocator::getInstance();
        
        if ($serviceLocator->has('searchService'))
        {
            return $serviceLocator->get('searchService');
        }
        
        throw new Exception('Не указаны настройки поиска');
    }
    
    /**
     * выполняет логику работы компонента
     */
    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }
}?>
<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 3/10/17
 * Time: 1:33 AM
 */

namespace WordWrap\Admin\Tasks;


use WordWrap\Admin\TaskController;
use WordWrap\Assets\Template\Mustache\MustacheTemplate;
use WordWrap\ORM\BaseModel;

class CrudIndex extends TaskController
{

    /**
     * @var int the current page the user is viewing
     */
    private $page;

    /**
     * @var BaseModel[] All models to currently list
     */
    private $models;

    /**
     * @var int how many total pages there are
     */
    private $totalPages;

    /**
     * override this to setup anything that needs to be done before
     * @param $action string the action the user is trying to complete
     */
    public function processRequest($action = null)
    {

        $this->page = ($_GET['p'] ?? 1) - 1;

        $modelClass = $this->task->CrudIndex->modelClass;

        $this->orders = $modelClass::fetchPage($this->page);

        $this->totalPages = ceil($modelClass::countRows() / 20);
    }

    /**
     * override to render the main page
     */
    protected function renderMainContent()
    {

        $modelClass = $this->task->CrudIndex->modelClass;

        $primaryKey = $modelClass::getPrimaryKey();

        $data = [
            "page_links" => '',
            "first_page" => $this->page == 0,
            "previous_page" => $this->page,
            "last_page" => $this->page == $this->totalPages - 1,
            "next_page" => $this->page + 2,
            "columns" => '',
            "rows" => ''
        ];

        foreach ($this->task->CrudIndex->CrudColumn as $column) {

            $columnTitle = str_replace('_', ' ', $column->name);
            $headerData = [
                'class_name' => $column->name,
                'display_name' => ucwords($columnTitle)
            ];

            $headerRow = new MustacheTemplate($this->lifeCycle, 'crud_header_entry', $headerData, 'admin_mustache');

            $data['columns'].= $headerRow->export();
        }

        foreach ($this->models as $model) {

            $rowData = [
                'id' => $modelClass->{$primaryKey},
                'values' => ''
            ];

            foreach ($this->task->CrudIndex->CrudColumn as $column) {

                $rowEntryData = [
                    'class_name' => $column->name,
                ];

                if ($column->trueValue && $column->falseValue) {
                    $rowEntryData['value'] = $model->{$column->name} ? $column->trueValue : $column->falseValue;
                }
                else {
                    $rowEntryData['value'] = $model->{$column->name};
                }

                $template = new MustacheTemplate($this->lifeCycle, 'crud_row_entry', $rowEntryData, 'admin_mustache');

                $rowData['values'].= $template->export();
            }

            $template = new MustacheTemplate($this->lifeCycle, 'crud_row', $rowData, 'admin_mustache');

            $data['rows'].= $template->export();
        }

        $i = 0;
        while ($i < $this->totalPages) {

            $i++;
            $data = [
                'page' => $i,
                'active' => $i == $this->page
            ];

            $template = new MustacheTemplate($this->lifeCycle, "crud_page_link", $data, 'admin_mustache');

            $data['page_links'].= $template->export();

        }

        $template = new MustacheTemplate($this->lifeCycle, "crud_index", $data, 'admin_mustache');

        return $template->export();
    }

    /**
     * override to render the main page
     */
    protected function renderSidebarContent()
    {
        // TODO: Implement renderSidebarContent() method.
    }
}
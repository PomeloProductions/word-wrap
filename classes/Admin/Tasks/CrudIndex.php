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
     * @var float the width of each column in this index
     */
    private $columnWidth;

    /**
     * override this to setup anything that needs to be done before
     * @param $action string the action the user is trying to complete
     */
    public function processRequest($action = null)
    {

        $this->page = ($_GET['p'] ?? 1) - 1;

        $modelClass = $this->task->CrudIndex->modelClass;

        $this->models = $modelClass::fetchPage($this->page);

        $this->totalPages = ceil($modelClass::countRows() / 20);

        $this->columnWidth = (1 / (count($this->task->CrudIndex->CrudColumn) + 1) * 100);
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
                'column_width' => $this->columnWidth,
                'class_name' => $column->name,
                'display_name' => ucwords($columnTitle)
            ];

            $headerRow = new MustacheTemplate($this->lifeCycle, 'crud_header_entry', $headerData, 'admin_mustache');

            $data['columns'].= $headerRow->export();
        }

        foreach ($this->models as $model) {

            $rowData = [
                'column_width' => $this->columnWidth,
                'id' => $modelClass->{$primaryKey},
                'admin_page' => $this->adminController->getCurrentPage()->getSlug(),
                'view_task' => $this->task->CrudIndex->viewTask,
                'values' => ''
            ];

            foreach ($this->task->CrudIndex->CrudColumn as $column) {

                $rowEntryData = [
                    'column_width' => $this->columnWidth,
                    'class_name' => $column->name,
                ];

                if ($column->isImage) {
                    $rowEntryData['value'] = '<img style="max-width:150px; max-height: 150px" src="' . $model->{$column->name} . '"/>';
                }
                elseif ($column->trueValue && $column->falseValue) {
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
            $pageLinkData = [
                'page' => $i,
                'active' => $i == $this->page
            ];

            $template = new MustacheTemplate($this->lifeCycle, "crud_page_link", $pageLinkData, 'admin_mustache');

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
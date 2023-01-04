<?php

namespace App\Http\Admin;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminSection;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Model\ModelConfiguration;
use SleepingOwl\Admin\Section;

/**
 * Class Posts
 *
 * @property \App\Models\Post $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Posts extends Section implements Initializable
{
    /**
     * @var \App\Models\Post
     */
    protected $model;

    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $this->addToNavigation(100, function() {
            return \App\Models\Post::count();
        })->setIcon('fas fa-file');
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('title', 'Title')->setHtmlAttribute('class', 'text-left')
                ->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('title', 'like', '%'.$search.'%');
                })
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('created_at', $direction);
                })
            ,
            AdminColumn::text('created_at', 'Created / updated')
                ->setWidth('200px')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('updated_at', $direction);
                })
                ->setSearchable(false)
            ,
        ];

        $display = AdminDisplay::datatables()
            ->setName('posts')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;

        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $tabs = AdminDisplay::tabbed();

        $tabs->setTabs(function ($id) {
            return [
                AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
                    AdminFormElement::columns()
                        ->addColumn([
                            AdminFormElement::text('title', 'Title')->required(),
                            AdminFormElement::select('cat_id', 'Category', PostCategory::class)->required(),
                            AdminFormElement::wysiwyg('text', 'Text', 'ckeditor')->required(),
                        ], 'col-xs-12 col-sm-12 col-md-8 col-lg-8')
                        ->addColumn([
                            AdminFormElement::datetime('created_at', 'Date and time')->setVisible(true)->setReadonly(false),
                            AdminFormElement::image('img', 'Preview')->required(),
                        ], 'col-xs-12 col-sm-12 col-md-4 col-lg-4'),
                ]))->setLabel('Data')
                ,
                AdminDisplay::tab(AdminForm::elements([
                    AdminFormElement::columns()->addColumn([
                        AdminFormElement::text('meta_title', 'Meta Title'),
                        AdminFormElement::textarea('meta_description', 'Meta Description'),
                    ], 'col-xs-12 col-sm-12 col-md-6 col-lg-6'),
                ]))->setLabel('SEO')
                ,
            ];
        });

        $form = AdminForm::form()->addElement($tabs);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'cancel'  => (new Cancel()),
        ]);

        return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        $form = $this->onEdit(null, $payload);
        $form->getButtons()->setButtons([
            'save_and_close'  => new SaveAndClose(),
            'cancel'  => (new Cancel()),
        ]);

        return $form;
    }

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return true;
    }
}

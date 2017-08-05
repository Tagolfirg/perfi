<?php

namespace app\classes;

/**
 * Общие настройки виджета GridView.
 */
class GridView extends \kartik\grid\GridView {

    /**
     * @var boolean whether the grid table will have a `responsive` style. Applicable only if `bootstrap` is `true`.
     *     Defaults to `true`.
     */
    public $responsiveWrap = false;

    /**
     * Экспорт отключен...
     * При необходимости использовать - добавить в composer.json пакет "kartik-v/yii2-mpdf": "dev-master"
     */
    public $export = false;

    /**
     * @var string the layout that determines how different sections of the list view should be organized.
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{errors}`: the filter model error summary. See [[renderErrors()]].
     * - `{items}`: the list items. See [[renderItems()]].
     * - `{sorter}`: the sorter. See [[renderSorter()]].
     * - `{pager}`: the pager. See [[renderPager()]].
     */
    public $layout = "{items}\n{summary}\n{pager}";
    public $condensed = true;
    public $striped = false;
    public $hover = true;

}

<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;


class CustomHtmlService extends ServiceProvider
{
    /**
     * @param null $caption
     * @param string $captionIcon
     * @param null $routeName
     * @param string $buttonClass
     * @param string $buttonIcon
     * @return string
     */
    public static function formTitleBox(
        $caption = null,
        $captionIcon = "fa fa-cogs",
        $routeName = null,
        $buttonClass = "",
        $buttonIcon = "fa fa-plus"
    )
    {
        if (empty($captionIcon)) $captionIcon = "fa fa-cogs";
        if (empty($buttonClass)) $buttonClass = "";
        if (empty($buttonIcon)) $buttonIcon = "fa fa-plus";
        $HTML = "";
        $HTML .= "
            <div class=\"box-header\">
                <i class=\"" . $captionIcon . " font-dark\"></i>
                <h3 class=\"box-title\">" . $caption . "</h3>
        ";
        if ($routeName != null) {
            $HTML .= "
               <div class=\"box-tools\">
                    <div class=\"input-group input-group-sm\">
            ";
            $HTML .= self::createButton($buttonClass, $buttonIcon);
            $HTML .= "
                    </div>
                </div>
        ";
        }
        $HTML .= "
            </div>
        ";
        return $HTML;
    }

    /**
     * @param null $buttonClass
     * @param null $buttonIcon
     * @return string
     */
    public static function createButton($buttonClass = null, $buttonIcon = null)
    {
        if (empty($buttonClass)) $buttonClass = "btn-primary";
        if (empty($buttonIcon)) $buttonIcon = "fa fa-plus";
        $HTML = "";
        if (auth()->user()->can(self::routeName() . '.create')) {
            $HTML .= "
                <a href=\"" . route(self::routeName() . '.create') . "\" class=\"btn  mx-2 " . $buttonClass . "\">
                    Add New
                    <i class=\"" . $buttonIcon . "\"></i>
                </a>
            ";
        }
        return $HTML;
    }

    /**
     * @return mixed
     */
    public static function routeName()
    {
        $routes = explode('.', Route::getCurrentRoute()->getName());
        return $routes[0];
    }

    /**
     * @param null $caption
     * @param string $captionIcon
     * @return string
     */
    public static function filterBoxOpen($caption = null, $captionIcon = "fa fa-search")
    {
        if (empty($captionIcon)) $captionIcon = "fa fa-search";
        $HTML = "";
        $HTML .= "
            <div class=\"panel panel-success\">
                <div class=\"panel-heading\">
                    <h3 class=\"panel-title\"><i class=\"" . $captionIcon . "\"></i> " . $caption . "</h3>
                </div>
                <div class=\"panel-body\">
                    <div class=\"row\">


        ";
        return $HTML;
    }

    /**
     * @return string
     */
    public static function filterBoxClose()
    {
        $HTML = "";
        $HTML .= "
                    </div>
                </div>
            </div>
        ";
        return $HTML;
    }

    /**
     * @param $model
     * @param string $position
     * @return string
     */
    public static function customPaginate($model, string $position = 'bottom'): string
    {
        $HTML = "<div class='box-footer clearfix'><div class='row'>";
        $STYLE = "<style> .pagination {margin:0 !important; float: right !important;}</style>";
        $pagination = "<div class='col-md-9'>" . $model->appends($_GET)->links() . "</div>";
        $details = "<div class='col-md-3'>Showing " . ($model->firstItem() ?? 0) .
            " to " . ($model->lastItem() ?? 0) . " of " . $model->total() . "  entries</div>";

        $HTML .= ($STYLE . $details . $pagination);
        $HTML .= "</div></div>";
        return $HTML;
    }

    /**
     * @param string $reportTitle
     * @param string $routeLink
     * @param array $selectButton
     * @return string
     */
    public static function customPrintButton($reportTitle = '...', $routeLink = '#', $selectButton = array())
    {
        $HTML = "";

        foreach ($selectButton as $thisSelectButton) {
            if ($thisSelectButton == 'printPreview') $HTML .= self::printPreviewButton();
            if ($thisSelectButton == 'pdfButton') $HTML .= self::pdfButton($routeLink);
            if ($thisSelectButton == 'printButton') $HTML .= self::printButton($reportTitle);
            if ($thisSelectButton == 'backButton') $HTML .= self::backButton();
        }

        return $HTML;
    }

    /**
     * @return string
     */
    public static function printPreviewButton($class = '', $onlyIcon = 'no')
    {
        $HTML = "";

        //Print Preview Button
        $HTML .= "
            <a class='btn yellow btn-xs hidden-print mx-2 printPreview' >
                ";
        if ($onlyIcon == 'no') $HTML .= " Preview
                <i class='glyphicon glyphicon-camera'></i>
            </a>
        ";

        return $HTML;
    }

    /**
     * @param string $routeLink
     * @return string
     */
    public static function pdfButton($routeLink = '#', $class = '', $onlyIcon = 'no')
    {
        $HTML = "";

        $HTML .= "
        <a class=\"btn blue btn-xs  mx-2 hidden-print\" href=\"" . $routeLink . "\" id=\"pdfPrint\" >
            ";
        if ($onlyIcon == 'no') $HTML .= " PDF
            <i class=\"fa fa-file-pdf-o\"></i>
        </a>";

        return $HTML;
    }

    /**
     * @param string $reportTitle
     * @return string
     */
    public static function printButton($reportTitle = '...', $class = '', $onlyIcon = 'no')
    {
        $HTML = "";

        //Print Button
        $HTML .= "
            <a
                class=\"btn blue btn-xs mx-2 hidden-print '.$class.'\"
                onclick=\"javascript:document.title = '" . $reportTitle . "';javascript:window.print();\"
            >
                ";
        if ($onlyIcon == 'no') $HTML .= " Print
                <i class=\"fa fa-print\"></i>
            </a>
        ";

        return $HTML;
    }

    /**
     * @return string
     */
    public static function backButton($class = '', $onlyIcon = 'no')
    {
        $HTML = "";

        //Back Button
        if (auth()->user()->can(self::routeName() . '.index')) {
            $HTML .= "
                <a href=\"" . route(self::routeName() . '.index') . "\" class=\"btn btn-xs btn-danger  m-2 hidden-print $class\">
                    <i class=\"glyphicon glyphicon-hand-left\"></i>";
            if ($onlyIcon == 'no') $HTML .= " Back";
            $HTML .= "</a>";
        }

        return $HTML;
    }

    /**
     * @param string $reportTitle
     * @param string $routeLink
     * @param $id
     * @param array $selectButton
     * @param string $class
     * @param string $onlyIcon
     * @param array $othersPram
     * @return string
     */
    public static function actionButton($reportTitle = '...', $routeLink = '#', $id = '', $selectButton = array(), $class = '', $onlyIcon = 'no', $othersPram = array()): string
    {
        $HTML = "<div style='display: flex; min-width:102px !important; justify-content: flex-start;'>";

        if (in_array('cancelButton', $selectButton) && in_array('storeButton', $selectButton))
            $HTML = "<div style='display: flex; justify-content: flex-start;'>";

        foreach ($selectButton as $thisSelectButton) {
            if ($thisSelectButton == 'printPreview') $HTML .= self::printPreviewButton($class, $onlyIcon);
            if ($thisSelectButton == 'pdfButton') $HTML .= self::pdfButton($routeLink, $class, $onlyIcon);
            if ($thisSelectButton == 'printButton') $HTML .= self::printButton($reportTitle, $class, $onlyIcon);
            if ($thisSelectButton == 'backButton') $HTML .= self::backButton($class, $onlyIcon);
            if ($thisSelectButton == 'showButton') $HTML .= self::showButton($id, $class, $onlyIcon);
            if ($thisSelectButton == 'downloadButton') $HTML .= self::downloadButton($id, $class, $onlyIcon);
            if ($thisSelectButton == 'editButtonOnlyIcon') $HTML .= self::editButtonOnlyIcon($id);
            if ($thisSelectButton == 'editButton') $HTML .= self::editButton($id, $class, $onlyIcon);
            if ($thisSelectButton == 'deleteButton') $HTML .= self::deleteButton($id, $class, $onlyIcon);
            if ($thisSelectButton == 'deleteButtonWithForm') $HTML .= self::deleteButtonWithForm($id, $class);
            if ($thisSelectButton == 'storeButton') $HTML .= self::storeButton($class);
            if ($thisSelectButton == 'cancelButton') $HTML .= self::cancelButton($class);
        }

        $HTML .= "</div>";

        return $HTML;
    }

    /**
     * @param $id
     * @param string $class
     * @param string $onlyIcon
     * @return string
     */
    public static function showButton($id, $class = '', $onlyIcon = 'no')
    {
        $HTML = "";
        if (auth()->user()->can(self::routeName() . '.show')) {
            $HTML .= "<a href=\"" . route(self::routeName() . '.show', $id) . "\"
                class=\"btn btn-xs btn-success  m-2 $class\"
                title=\"Show\"
            >
                <i class=\"fa fa-eye\"></i>";
            if ($onlyIcon == 'no') $HTML .= "Show";
            $HTML .= "</a>";
        }

        return $HTML;
    }

    /**
     * @param $data
     * @return string
     */
    public static function ButtonCustom($data)
    {
        $HTML = "";
        if (auth()->user()->can($data['route'])) {
            $HTML .= "<a href=\"" . $data['URL'] . "\" target=\"" . (isset($data['target']) ? $data['target'] : '_self') . "\" class=\"" . $data['class'] . "\" title=\"" . $data['buttonName'] . "\">";
            $HTML .= "<i class=\"" . $data['buttonIcon'] . "\"></i>";
            if (isset($data['buttonNameDisplay'])):
                $HTML .= $data['buttonName'];
            endif;
            $HTML .= "</a>";
        }
        return $HTML;
    }

    /**
     * @param $id
     * @return string
     */
    public static function editButtonOnlyIcon($id)
    {
        $HTML = "";
        if (auth()->user()->can(self::routeName() . '.edit')) {
            $HTML .= "&nbsp;&nbsp;<a href=\"" . route(self::routeName() . '.edit', $id) . "\" class=\"btn mx-2  btn-xs btn-primary\" title=\"Edit\">
                <i class=\"fa fa-edit\"></i>
            </a>";
        }

        return $HTML;
    }

    /**
     * @param $id
     * @param string $class
     * @param string $onlyIcon
     * @return string
     */
    public static function editButton($id, $class = '', $onlyIcon = 'no')
    {
        $HTML = "";
        if (auth()->user()->can(self::routeName() . '.edit')) {
            $HTML .= "
            <a href=\"" . route(self::routeName() . '.edit', $id) . "\" class=\"btn btn-xs m-2 btn-primary\" title=\"Edit\">
                <i class=\"glyphicon glyphicon-pencil\"></i>";
            if ($onlyIcon == 'no') $HTML .= " Edit";
            $HTML .= "
 </a> ";
        }

        return $HTML;
    }

    /**
     * @param $id
     * @param string $class
     * @param string $onlyIcon
     * @return string
     */
    public static function deleteButton($id, $class = '', $onlyIcon = 'no')
    {
        $HTML = "";
        if (auth()->user()->can(self::routeName() . '.destroy')) {
            if (UtilityService::$delete_method == 1):
                $HTML .= "<a
                        href=\"" . route('common-delete.delete', ['id' => $id, 'route' => self::routeName()]) . "\"
                        class=\"btn btn-xs btn-danger m-2\"
                        data-target=\"#pop-up-modal\"
                        data-toggle=\"modal\"
                        title=\"Delete\"
                    >
                        <i class=\"fa fa-times\"></i>";
                if ($onlyIcon == 'no') $HTML .= "Delete";
                $HTML .= "</a>";
            else:
                self::deleteButtonWithForm($id, $class = '', $onlyIcon = 'no');
            endif;
        }

        return $HTML;
    }

    /**
     * @param $id
     * @param string $class
     * @param string $onlyIcon
     * @return string
     */
    public static function deleteButtonWithForm($id, $class = '', $onlyIcon = 'no')
    {
        $HTML = "";
        $HTML .= "&nbsp;&nbsp;
            <form style=\"padding-left:5px;padding-right:5px;\" method=\"POST\" class=\"form-inline pull-left\"
                    action=\"" . route(self::routeName() . '.destroy', $id) . "\"
                    onsubmit=\"return confirm('" . trans('common.Are you sure, you want to delete this') . "?')\"
            >
        ";
        $HTML .= method_field('DELETE');
        $HTML .= csrf_field();
        $HTML .= "<button type=\"submit\" class=\" m-2 btn btn-xs btn-danger delete_button_with_form " . $class . "\" id=\"delete_button_with_form_" . $id . "\"><i class=\"fa fa-trash\"></i>";
        if ($onlyIcon == 'no') $HTML .= "Delete</button>";
        $HTML .= "</form>&nbsp;&nbsp;";
        return $HTML;
    }

    /**
     * @param string $class
     * @return string
     */
    public static function storeButton($class = '', $onlyIcon = 'no')
    {
        $HTML = "";
        if (auth()->user()->can(self::routeName() . '.store')) {
            $HTML .= "
                <button type=\"submit\" class=\"btn btn-primary  text-bold m-2 " . $class . "\">
                    <i class=\"fa fa-check\"></i>";
            if ($onlyIcon == 'no') $HTML .= " <span class='hidden-mobile'>Save</span>
                </button>
            ";
        }
        return $HTML;
    }

    /**
     * @param string $class
     * @return string
     */
    public static function cancelButton($class = '', $onlyIcon = 'no')
    {
        $HTML = "";
        if (auth()->user()->can(self::routeName() . '.index')) {
            $HTML .= "
                <a href=\"" . route(self::routeName() . '.index') . "\" class=\"btn  text-bold  btn-danger  m-2 d-print-none kt-margin-r-10 " . $class . "\">
                    <i class=\"fa fa-times\"></i>";
            if ($onlyIcon == 'no') $HTML .= " <span class='kt-hidden-mobile'> Cancel</span>
                </a>
            ";
        }
        return $HTML;
    }

    /**
     * @return mixed
     */
    public static function passwordPinGenerate()
    {
        $pool = 'abcdefghjkmnopqrstuvwxyz';
        $string = substr(str_shuffle(str_repeat($pool, 3)), 0, 3);
        $digits = 3;
        $random_password = rand(pow(10, $digits - 1), pow(10, $digits) - 1) . $string;
        $returnValue['default_password'] = $random_password;
        $returnValue['default_pin'] = mt_rand(100000, 999999);
        return $returnValue;
    }

    /**
     * @param $data
     * @return string
     */
    public static function mobileNumberToInternationalFormat($data): string
    {
        //Remove any parentheses and the numbers they contain:
        $n = preg_replace("/\([0-9]+?\)/", "", $data['mobile_number']);

        //Strip spaces and non-numeric characters:
        $n = preg_replace("/[^0-9]/", "", $n);

        //Strip out leading zeros:
        $n = ltrim($n, '0');

        //Check if the number doesn't already start with the correct dialling code:
        if (!preg_match('/^' . $data['country_phone_code'] . '/', $n)) {
            $n = $data['country_phone_code'] . $n;
        }

        //return the converted number:
        return $n;
    }

    /**
     * @param $json
     * @return string
     */
    public static function prettyPrint($json)
    {
        $result = '';
        $level = 0;
        $in_quotes = false;
        $in_escape = false;
        $ends_line_level = NULL;
        $json_length = strlen($json);

        for ($i = 0; $i < $json_length; $i++) {
            $char = $json[$i];
            $new_line_level = NULL;
            $post = "";
            if ($ends_line_level !== NULL) {
                $new_line_level = $ends_line_level;
                $ends_line_level = NULL;
            }
            if ($in_escape) {
                $in_escape = false;
            } else if ($char === '"') {
                $in_quotes = !$in_quotes;
            } else if (!$in_quotes) {
                switch ($char) {
                    case '}':
                    case ']':
                        $level--;
                        $ends_line_level = NULL;
                        $new_line_level = $level;
                        break;

                    case '{':
                    case '[':
                        $level++;
                    case ',':
                        $ends_line_level = $level;
                        break;

                    case ':':
                        $post = " ";
                        break;

                    case " ":
                    case "\t":
                    case "\n":
                    case "\r":
                        $char = "";
                        $ends_line_level = $new_line_level;
                        $new_line_level = NULL;
                        break;
                }
            } else if ($char === '\\') {
                $in_escape = true;
            }
            if ($new_line_level !== NULL) {
                $result .= "\n" . str_repeat("\t", $new_line_level);
            }
            $result .= $char . $post;
        }
        return $result;
    }

    /**
     * @param $amount
     * @param $value
     * @return float|int|string|string[]|null
     */
    public static function calculate($amount, $value)
    {
        if (strpos($value, '%') !== false) {
            $value = preg_replace("/[^0-9.\-]/", "", $value);
            $value = $amount * $value / 100;
            return $value;
        }
        if (strpos($value, '-') !== false) {
            $value = preg_replace("/[^0-9.]/", "", $value);
            $value = $value * -1;
            return $value;
        }
        $value = preg_replace("/[^0-9.]/", "", $value);
        return $value;
    }

    /**
     * Custom Codes for beautification
     */

    /**
     * @param $tags
     * @param null $field
     * @param false $isObject
     * @param string $icon
     * @return string
     */
    public static function displayTags($tags, $field = null, bool $isObject = false, string $icon = 'fa fa-tags'): string
    {
        $HTML = "";

        if (count($tags) > 0) {
            foreach ($tags as $index => $tag) {
                $HTML .= "<label class='label label-primary m-2' style='display: inline-block'>";
                $HTML .= "<i class='$icon'></i> ";
                if ($isObject == true)
                    $HTML .= $tag->$field;
                else
                    $HTML .= $tag[$field];
                $HTML .= "</label>";
            }

        } else {
            $HTML .= 'N/A';
        }
        return $HTML;
    }

    /**
     * @param $tags
     * @param null $field
     * @param false $isObject
     * @param string $icon
     * @param int $limit
     * @return string
     */
    public static function displayTagsLimited($tags, $field = null, bool $isObject = false, string $icon = 'fa fa-tags', int $limit = 5): string
    {
        $HTML = "";

        if (count($tags) > 0) {
            $total_tags = count($tags);

            foreach ($tags as $index => $tag) {
                $current = $index;
                if (($index + 1) <= $limit) {
                    $HTML .= "<label class='label label-primary m-2' style='display: inline-block'>";
                    $HTML .= "<i class='$icon'></i> ";
                    if ($isObject == true)
                        $HTML .= $tag->$field;
                    else
                        $HTML .= $tag[$field];
                    $HTML .= "</label>";
                } else
                    break;
            }

            if (($total_tags - $limit) > 0)
                $HTML .= " <a href=\"#\" class='text-bold'>" . ($total_tags - $limit) . " more</a>";

        } else {
            $HTML .= 'N/A';
        }
        return $HTML;
    }


    /**
     * @param Model $model
     * @param string $field
     * @param array $options
     * @param null $current_value
     * @param array $states
     * @return string
     */
    public
    static function flagChangeButton(Model $model, string $field, array $options, $current_value = null, array $states = []): string
    {
        //Get Model information
        $model_id_field = $model->getKeyName();
        $model_id = $model->$model_id_field;
        $model_path = get_class($model);
        //generate switch states
        $options['on'] = $options['on'] ?? array_shift($options);
        $options['off'] = $options['off'] ?? array_shift($options);
        //generate switch states colors
        $states['on'] = $states['on'] ?? 'success';
        $states['off'] = $states['off'] ?? 'danger';

        $HTML = "<input class='toggle-class' type='checkbox' ";
        $HTML .= "data-onstyle='" . $states['on'] . "' data-offstyle='" . $states['off'] . "' data-toggle='toggle' data-size='mini' data-height='30px'";
        $HTML .= "data-model='$model_path' data-id='$model_id' data-field='$field' ";
        $HTML .= "data-on='" . $options['on'] . "' data-off='" . $options['off'] . "'";
        if (is_null($current_value)) {
            $HTML .= ($options['on'] == $model->$field) ? " checked" : "";
        } else {
            $HTML .= ($options['on'] == $current_value) ? " checked" : "";
        }

        $HTML .= ">";

        return $HTML;
    }

    /**
     * Download Link button only for Ebook
     *
     * @param $id
     * @param string $class
     * @param string $onlyIcon
     * @return string
     */

    public static function downloadButton($id, $class = '', $onlyIcon = 'no')
    {
        $HTML = "";
        if (auth()->user()->can('ebook.download')) {
            $HTML .= " <a
                href=\"" . route('ebooks.download', $id) . "\"
                class=\"btn btn-xs btn-warning m-2 '.$class.'\"
                title=\"Download\"
            >
                <i class=\"fa fa-download\"></i>";

            if ($onlyIcon == 'no')
                $HTML .= "Download
            </a>
        ";
        }
        return $HTML;
    }

    /**
     * @param int $ratingPoint
     * @return string
     */
    public
    static function startRating($ratingPoint = 0): string
    {
        $HTML = '';
        $HTML .= '<i class="';
        if ($ratingPoint >= 1): $HTML .= " fa fa-star";
        else: $HTML .= " fa fa-star-o"; endif;
        $HTML .= '" style="color:#DAA520"></i>';
        $HTML .= '<i class="';
        if ($ratingPoint >= 2): $HTML .= " fa fa-star";
        else: $HTML .= " fa fa-star-o"; endif;
        $HTML .= '" style="color:#DAA520"></i>';
        $HTML .= '<i class="';
        if ($ratingPoint >= 3): $HTML .= " fa fa-star";
        else: $HTML .= " fa fa-star-o"; endif;
        $HTML .= '" style="color:#DAA520"></i>';
        $HTML .= '<i class="';
        if ($ratingPoint >= 4): $HTML .= " fa fa-star";
        else: $HTML .= " fa fa-star-o"; endif;
        $HTML .= '" style="color:#DAA520"></i>';
        $HTML .= '<i class="';
        if ($ratingPoint >= 5): $HTML .= " fa fa-star";
        else: $HTML .= " fa fa-star-o"; endif;
        $HTML .= '" style="color:#DAA520"></i>';
        return $HTML;
    }

    /**
     * @param $number
     * @param int $decimals
     * @return string
     */
    public static function numberFormat($number, int $decimals = 2): string
    {
        return number_format($number, 2, '.', '');
    }

    /**
     * @param $number
     * @param int $decimals
     * @return string
     */
    public static function customNumberFormat($number, int $decimals): string
    {
        return number_format(str_replace(',', '', $number), $decimals, '.', ',');
    }

    /**
     * @param string $current
     * @return string
     */
    public static function saleStatus(string $current): string
    {
        $HTML = '<label class="label label-';

        switch ($current) {
            case 'pending' :
                $HTML .= 'warning">Pending</label>';
                break;
            case 'processing' :
                $HTML .= 'info">Processing</label>';
                break;
            case 'completed' :
                $HTML .= 'success">Completed</label>';
                break;
            case 'canceled' :
                $HTML .= 'danger">Canceled</label>';
                break;
            case 'refunded' :
                $HTML .= 'default">Refunded</label>';
                break;
            default :
                $HTML .= 'default">Temporary</label>';
                break;
        }

        return $HTML;
    }

    /**
     * @param string $current
     * @return string
     */
    public static function paymentStatus(string $current): string
    {
        $HTML = '<label class="label label-';

        switch ($current) {
            case 'pending' :
                $HTML .= 'default">Pending</label>';
                break;
            case 'unpaid' :
                $HTML .= 'danger">Un Paid</label>';
                break;
            case 'paid' :
                $HTML .= 'success">Full Paid</label>';
                break;
            case 'canceled' :
                $HTML .= 'info">Canceled</label>';
                break;

            case 'partial' :
                $HTML .= 'info">Partial</label>';
                break;

            case 'refunded' :
                $HTML .= 'warning">Refunded</label>';
                break;
            default :
                $HTML .= 'default">Temporary</label>';
                break;
        }

        return $HTML;
    }
}

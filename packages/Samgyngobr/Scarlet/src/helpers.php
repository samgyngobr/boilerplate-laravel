<?php

function formGen( $fields, $action )
{
    $str = '<form method="post" class="form-horizontal" enctype="multipart/form-data" >';

    foreach ($fields as $key => $value)
    {
        $required = ( $value['required'] ) ? 'required' : '';

        switch ( $value['type'] )
        {

            case '1':
                $str .= '
                <div class="mb-3 row">
                    <label class="col-form-label col-md-2 text-md-end" for="' . $value['name'] . '">' . $value['label'] . '</label>
                    <div class="col-md-10">
                        <input type="text" id="' . $value['name'] . '" class="form-control" placeholder="' . $value['label'] . '" name="' . $value['name'] . '" value="' . ( isset( $value['value'] ) ? $value['value'] : '' ) . '" ' . $required . ' >
                    </div>
                </div>
                ';
                break;


            case '2':
                $str .= '
                <div class="mb-3 row">
                    <label class="col-form-label col-md-2 text-md-end" for="' . $value['name'] . '">' . $value['label'] . '</label>
                    <div class="col-md-10">
                        <input type="text" id="' . $value['name'] . '" class="form-control integer" placeholder="' . $value['label'] . '" name="' . $value['name'] . '" value="' . ( isset( $value['value'] ) ? $value['value'] : '' ) . '" ' . $required . ' >
                    </div>
                </div>
                ';
                break;


            case '3':
                $str .= '
                <div class="mb-3 row">
                    <label class="col-form-label col-md-2 text-md-end" for="' . $value['name'] . '">' . $value['label'] . '</label>
                    <div class="col-md-10">
                        <input type="text" id="' . $value['name'] . '" class="form-control double" placeholder="' . $value['label'] . '" name="' . $value['name'] . '" value="' . ( isset( $value['value'] ) ? $value['value'] : '' ) . '" ' . $required . ' data-parsley-pattern="^[0-9]+(\\.[0-9]+)?$" >
                    </div>
                </div>
                ';
                break;


            case '4':
                $str .= '
                <div class="mb-3 row">
                    <label class="col-form-label col-md-2 text-md-end" for="' . $value['name'] . '">' . $value['label'] . '</label>
                    <div class="col-md-10">
                        <textarea class="form-control ckeditor" id="' . $value['name'] . '" name="' . $value['name'] . '" rows="3"  ' . $required . ' >' . ( isset( $value['value'] ) ? $value['value'] : '' ) . '</textarea>
                    </div>
                </div>
                ';
                break;


            case '5':
                $str .= '
                <div class="mb-3 row">
                    <label class="col-form-label col-md-2 text-md-end" for="' . $value['name'] . '">' . $value['label'] . '</label>
                    <div class="col-md-10">
                        <select id="' . $value['name'] . '" class="form-select" name="' . $value['name'] . '" ' . $required . ' >
                            <option value="">' . __('scarlet.select') . '</option>
                            ';

                            foreach ( $value['options'] as $k => $v )
                                $str .= '<option value="' . $v['value'] . '" ' . ( isset( $value['value'] ) && $value['value'] == $v['value'] ? ' selected="selected" ' : '' ) .' >' . $v['name'] . '</option>';

                            $str .= '
                        </select>
                    </div>
                </div>
                ';
                break;


            case '6':
                $str .= '
                <div class="mb-3 row">
                    <label class="col-form-label col-md-2 text-md-end" for="' . $value['name'] . '">' . $value['label'] . '</label>
                    <div class="col-md-10 d-flex">
                        ';

                foreach ( $value['options'] as $k => $v )
                    $str .= '
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"  id="' . $value['name'] . '-' . $k . '" value="' . $v['value'] . '" name="' . $value['name'] . '" type="radio" ' . ( ( isset($value['value'] ) && $v['value'] == $value['value'] ) ? 'checked="checked"' : '' ) . ' >
                            <label class="form-check-label" for="' . $value['name'] . '-' . $k . '">' . $v['name'] . '</label>
                        </div>
                    ';

                $str .= '
                    </div>
                </div>
                ';
                break;


            case '7':
                $str .= '
                <div class="mb-3 row">
                    <label class="col-form-label col-md-2 text-md-end" for="' . $value['name'] . '">' . $value['label'] . '</label>
                    <div class="col-md-10 d-flex">
                        ';

                        foreach ( $value['options'] as $k => $v )
                            $str .= '
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input   id="' . $value['name'] . '-' . $k . '" value="' . $v['value'] . '" name="' . $value['name'] . '[]" type="checkbox" ' . ( isset( $value['value'] ) && in_array( $v['value'], explode( ';', $value['value'] ) ) ? 'checked="checked"' : '' ) . ' >
                                    <label class="form-check-label" for="' . $value['name'] . '-' . $k . '">' . $v['name'] . '</label>
                                </div>
                            ';

                        $str .= '
                    </div>
                </div>
                ';
                break;


            case '8':
                if( !isset( $value['value'] ) )
                    $btn = '<div class="input-group">
                                <input type="file" class="form-control" name="' . $value['name'] . '" id="' . $value['name'] . '" ' . ( ( $action=='edit' ) ? '' : $required ) . ' >
                            </div>';
                else
                    $btn = '<div class="input-group">
                                <input type="file" class="form-control" name="' . $value['name'] . '" id="' . $value['name'] . '" ' . ( ( $action=='edit' ) ? '' : $required ) . ' >
                                <a class="btn btn-outline-secondary" href="' . Config::get('app.sk_file_path') . $value['value'] . '" target="_blank" ><i class="fa fa-download"></i></a>
                            </div>';
                $str .= '
                    <div class="mb-3 row">
                        <label class="col-form-label col-md-2 text-md-end" >' . $value['label'] . '</label>
                        <div class="col-md-10">' . $btn . '</div>
                    </div>
                    ';
                break;


            case '9':
                if( !isset( $value['value'] ) )
                    $btn = '<div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="' . $value['name'] . '" id="' . $value['name'] . '" ' . ( ( $action=='edit' ) ? '' : $required ) . ' >
                                    <label class="custom-file-label" for="' . $value['name'] . '">' . __( 'scarlet.choose_file' ) . '</label>
                                </div>
                            </div>';
                else
                    $btn = '<div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="' . $value['name'] . '" id="' . $value['name'] . '" ' . ( ( $action=='edit' ) ? '' : $required ) . ' >
                                    <label class="custom-file-label" for="' . $value['name'] . '">' . __( 'scarlet.choose_file' ) . '</label>
                                </div>
                                <span class="input-group-btn">
                                    <a class="btn btn-default" href="' . Config::get('app.sk_file_path') . $value['value'] . '" target="_blank" ><i class="fa fa-download"></i></a>
                                </span>
                            </div>';
                $str .= '
                    <div class="mb-3 row">
                        <label class="col-form-label col-md-2 text-md-end" >' . $value['label'] . '</label>
                        <div class="col-md-10">' . $btn . '</div>
                    </div>
                    ';
                break;


        } // switch ( $value['type'] )

    } // foreach ($fields as $key => $value)

    $str .= '
        <div class="mb-3 row">
            <div class="col-md-10 offset-md-2">
                <button type="submit" class="btn btn-success">' . __('scarlet.save') . '</button>
            </div>
        </div>';

    $str .= '</form>';

    return $str;
}





function listGen( $data, $fieldLabels, $area, $url )
{
    $labels = [];

     $str = '<table class="table" >';

        $str .= '<thead class="card-header" ><tr>';

            foreach ($fieldLabels as $key => $value)
            {
                $str      .= "<th>{$value['label']}</th>";
                $labels[]  = $value['name'];
            }

            $str .= '<th>' . __('scarlet.last_update') . '</th>';

            if( $area['gallery'] )
                $str .= '<th>' . __('scarlet.gallery') . '</th>';

            $str .= '<th>' . __('scarlet.published') . '</th>';
            $str .= '<th>' . __('scarlet.actions') . '</th>';

        $str .= '</tr></thead>';

        $str .= '<tbody>';

            foreach( $data as $k => $v )
            {
                $str .= '<tr>';

                foreach ($labels as $v_)
                    $str .= '<td>' . $v['fields'][$v_] . '</td>';

                $datetimeFormat = ( Config::get('app.sk_datetime_format') ) ? Config::get('app.sk_datetime_format') : 'Y/m/d H:i';

                $str .= '<td style=" width: 15%; " >' . ( isset( $v['fields']['last_update'] ) ? date( $datetimeFormat, strtotime( $v['fields']['last_update'] ) ) : '' ) . '</td>';

                if( $area['gallery'] )
                    $str .= '<td style=" width: 10%; " ><a class="text-info" href="' . $url . $area['url'] . '/gallery/' . $v['id'] . '"><i class="fas fa-image"></i></a></td>';

                $str .= '<td style=" width: 10%; " >';
                    if ( $v['published'] )
                        $str .= ' <a class="text-success" href="' . $url . $area['url'] . '/unpublish/' . $v['id'] . '"><i class="fas fa-check"></i></a>';
                    else
                        $str .= ' <a class="text-danger"  href="' . $url . $area['url'] . '/publish/'   . $v['id'] . '"><i class="fas fa-times"></i></a>';
                $str .= '</td>';

                $str .= '<td style=" width: 10%; " >';
                    $str .= ' <a class="text-info"          href="' . $url . $area['url'] . '/edit/'   . $v['id'] . '"><i class="fas fa-edit"  ></i></a> ';
                    $str .= ' <a class="text-danger delete" href="' . $url . $area['url'] . '/delete/' . $v['id'] . '"><i class="fas fa-trash" ></i></a> ';
                $str .= '</td>';

                $str .= '</tr>';

            } // foreach( $data as $k => $v )

        $str .= '</tbody>';

    $str .= '</table>';

    return $str;

}

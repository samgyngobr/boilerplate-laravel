
@extends('samgyngobr.scarlet.app')


@section('header')

  <i class="dec fas fa-cog"></i>

  <div class="d-flex gap-3">

    <a href="{{$skUrl}}config" class="pull-left d-flex align-items-center text-white mr-4">
      <i class="fas fa-chevron-left"></i>
    </a>
    <span>{{ __('scarlet.configuration') }} - {{$title ?? ''}}</span>

  </div>

@endsection


@section('content')

  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif

  <form action="{{$url ?? ''}}" method="POST" enctype="multipart/form-data" >

    @method( $method )
    @csrf

    <div class="row">
      <div class="col-lg-8">

        <div class="card elevation mb-4">

          <div class="card-header"> {{ __('scarlet.details') }} </div>

          <div class="card-body">

              <div class="mb-3 row">
                <label class="col-form-label col-md-2 text-start text-md-end" for="name">{{ __('scarlet.title') }}</label>
                <div class="col-md-10">
                  <input type="text" id="name" class="form-control" placeholder="{{ __('scarlet.title') }}" name="name" value="{{ $post->label ?? '' }}" >
                </div>
              </div>

              <div class="mb-3 row">
                <label class="col-form-label col-md-2 text-start text-md-end" >{{ __('scarlet.gallery') }}</label>
                <div class="col-md-10 d-flex align-items-center">

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" id="gallery0" type="radio" value="0" name="gallery" {{ isset($post->gallery) && ( $post->gallery == 0 || !$post->gallery ) ? 'checked="checked"' : '' }} >
                    <label class="form-check-label" for="gallery0"> {{ __('scarlet.no') }} </label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" id="gallery1" type="radio" value="1" name="gallery" {{ isset($post->gallery) && $post->gallery == 1 ? 'checked="checked"' : '' }} >
                    <label class="form-check-label" for="gallery1"> {{ __('scarlet.yes') }} </label>
                  </div>

                </div>
              </div>

              <div class="mb-3 row">
                <label class="col-form-label col-md-2 text-start text-md-end" >{{ __('scarlet.type') }}</label>
                <div class="col-md-10 d-flex align-items-center">

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" id="multiple0" type="radio" value="0" name="multiple" {{ isset($post->multiple) && ( $post->multiple == 0 || !$post->multiple ) ? 'checked="checked"' : '' }} >
                    <label class="form-check-label" for="multiple0"> {{ __('scarlet.unique') }} </label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" id="multiple1" type="radio" value="1" name="multiple" {{ isset($post->multiple) && $post->multiple == 1 ? 'checked="checked"' : '' }} >
                    <label class="form-check-label" for="multiple1"> {{ __('scarlet.collection') }} </label>
                  </div>

                </div>
              </div>

          </div>

        </div>

        <h5 class="mb-4 pb-2 border-bottom" >

          {{ __('scarlet.fields') }}

          <a class="pull-right" data-bs-toggle="modal" data-bs-target="#new" href="#">
            <i class="fas fa-plus-circle"></i>
          </a>

        </h5>

        <div class="card elevation mb-4">
          <div class="card-body has-table">

            <table class="table" id="fieldsTable" >

              <thead class="card-header">
                <tr>
                  <th>{{ __('scarlet.field') }}</th>
                  <th width="15%" >{{ __('scarlet.type') }}</th>
                  <th width="15%" >{{ __('scarlet.index') }}</th>
                  <th width="15%" >{{ __('scarlet.options') }}</th>
                </tr>
              </thead>

              <tbody></tbody>

            </table>

            <textarea class="d-none form-control" type="text" name="json" id="jsonField" readonly="" >{{$post->json ?? '' }}</textarea>

          </div>
        </div>

        <div class="mb-4">
          <button type="submit" class="btn btn-success"> <i class="icon-ok"></i> Save </button>
        </div>

      </div> <!-- / .row -->
    </div> <!-- / .col-md-8 -->

  </form>


  <!-- sample modal content -->
  <div id="new" data-id="" class="modal" tabindex="-1" role="dialog" aria-labelledby="n" aria-hidden="true">
    <div id="newPre" class="modal-dialog modal-lg">
      <div class="modal-content">

        <form id="fieldsForm" class="form-horizontal" data-op="add" method="post" action="" >

          <div class="modal-header">
            <h4 class="modal-title" id="n">{{ __('scarlet.fields') }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true" aria-label="Close" ></button>
          </div>

          <div class="modal-body">

            <div class="mb-3 row">
              <label class="col-form-label col-md-2 text-start text-md-end" for="field">{{ __('scarlet.field') }}</label>
              <div class="col-md-8">
                <input type="text" class="form-control" placeholder="{{ __('scarlet.field') }}" id="field" name="field" >
              </div>
            </div>

            <div class="mb-3 row">
              <label class="col-form-label col-md-2 text-start text-md-end">{{ __('scarlet.required') }}</label>
              <div class="col-md-8 d-flex align-items-center">

                <div class="form-check form-check-inline">
                  <input class="form-check-input required" id="required0" value="0" name="required" checked="checked" type="radio">
                  <label class="form-check-label" for="required0"> {{ __('scarlet.no') }} </label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input required" id="required1" value="1" name="required" type="radio">
                  <label class="form-check-label" for="required1"> {{ __('scarlet.yes') }} </label>
                </div>

              </div>
            </div>

            <div class="mb-3 row">
              <label class="col-form-label col-md-2 text-start text-md-end">{{ __('scarlet.index') }}</label>
              <div class="col-md-8 d-flex align-items-center">

                <div class="form-check form-check-inline">
                  <input class="form-check-input index" id="index0" value="0" name="index" checked="checked" type="radio">
                  <label class="form-check-label" for="index0"> {{ __('scarlet.no') }} </label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input index" id="index1" value="1" name="index" type="radio">
                  <label class="form-check-label" for="index1"> {{ __('scarlet.yes') }} </label>
                </div>

              </div>
            </div>

            <div class="mb-3 row">
              <label class="col-form-label col-md-2 text-start text-md-end" for="order">{{ __('scarlet.order') }}</label>
              <div class="col-md-8">
                <input type="number" class="form-control" placeholder="{{ __('scarlet.order') }}" id="order" name="order" >
              </div>
            </div>

            <div class="mb-3 row">
              <label class="col-form-label col-md-2 text-start text-md-end" for="type">{{ __('scarlet.type') }}: </label>
              <div class="col-md-8">
                <select class="form-select" id="type" name="type" >
                  <option value="" >{{ __('scarlet.select')   }}...</option>
                  <option value="1">{{ __('scarlet.text')     }}</option>
                  <option value="2">{{ __('scarlet.integer')  }}</option>
                  <option value="3">{{ __('scarlet.double')   }}</option>
                  <option value="4">{{ __('scarlet.textarea') }}</option>
                  <option value="5">{{ __('scarlet.select')   }}</option>
                  <option value="6">{{ __('scarlet.radio')    }}</option>
                  <option value="7">{{ __('scarlet.checkbox') }}</option>
                  <option value="8">{{ __('scarlet.image')    }}</option>
                  <option value="9">{{ __('scarlet.upload')   }}</option>
                </select>
              </div>
              <div id="add_options_button" class="d-none col-md-2">
                <button type="button" id="add_field_button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
              </div>
            </div>

            <div id='input_fields_wrap'></div>

            <input type="hidden" class="form-control" placeholder="" id="namef" name="name" >

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('scarlet.close') }}</button>
            <button type="submit" class="btn btn-success" name="op" value="new"  >{{ __('scarlet.save')  }}</button>
          </div>

        </form>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->





  <script type="text/javascript">

    document.addEventListener("DOMContentLoaded", function(event) {


      // if editing load fields content
      var json = document.getElementById('jsonField').value;

      if( json !== '' )
        updateTable();


      // edit
      $(document.body).on('click', '.btnedt', function(event) {

        event.preventDefault();

        var id         = this.getAttribute('data-val');
        var currentVal = JSON.parse( document.getElementById('jsonField').value );
        var item       = currentVal.splice(id, 1);
        var myModal    = new bootstrap.Modal(document.getElementById("new"), {});
        myModal.show();

        document.getElementById('required0').setAttribute( 'checked', false );
        document.getElementById('required1').setAttribute( 'checked', false );
        document.getElementById('index0'   ).setAttribute( 'checked', false );
        document.getElementById('index1'   ).setAttribute( 'checked', false );

        document.getElementById('field').value = item[0][0]['value'];
        document.getElementById('order').value = item[0][3]['value'];
        document.getElementById('type' ).value = item[0][4]['value'];
        document.getElementById('namef').value = item[0][5]['value'];
        document.getElementById('new'       ).setAttribute( 'data-id', id    );
        document.getElementById('fieldsForm').setAttribute( 'data-op', "edt" );
        document.querySelector('input.required[value="' + item[0][1]['value'] + '"]').setAttribute( 'checked', 'checked' );
        document.querySelector('input.index[value="'    + item[0][2]['value'] + '"]').setAttribute( 'checked', 'checked' );


        if( item[0][4]['value'] == 5 || item[0][4]['value'] == 6 || item[0][4]['value'] == 7 )
          document.getElementById('add_options_button').classList.remove('d-none');
        else
          document.getElementById('add_options_button').classList.add('d-none');


        item[0].forEach(function(value, key){

          var posA = strpos( value.name, 'label[' );
          var posB = strpos( value.name, ']' );

          if( posA !== false && posB !== false )
            var val = value.name.substr( posA+6, posB-(posA+6) );
          else
            var val = '--';

          if(val.match(/^-{0,1}\d+$/))
          {
            var v = '';

            item[0].forEach(function(vl, k){

              if( vl.name == 'value[' + val + ']' )
                v = vl.value;
            });

            var div  = document.createElement('div');
            div.className = "mb-3 row";

            var str = `
              <label class="col-form-label col-md-2 text-start text-md-end">{{ __('scarlet.label') }}: </label>
              <div class="col-md-3">
                <input type="text" class="form-control" placeholder="{{ __('scarlet.text') }}" name="label[` + val + `]" value="` + value.value + `" >
              </div>
              <label class="col-form-label col-md-2 text-start text-md-end" for="desc">{{ __('scarlet.value') }}: </label>
              <div class="col-md-3">
                <input type="text" class="form-control" placeholder="{{ __('scarlet.value') }}" name="value[` + val + `]" value="` + v + `" >
              </div>
              <div class="col-md-1" >
                <a class="btn btn-primary remove_field" href="#"><i class="fa fa-minus"></i></a>
              </div>
            `;

            div.innerHTML = str;
            document.getElementById('input_fields_wrap').appendChild( div );

          } // if(val.match(/^-{0,1}\d+$/))

        }); // item[0].forEach(function(value, key){

      }); // onClick .btnedt


      var max_fields = 20; //maximum input boxes allowed
      var x          = 1; //initlal text box count


      document.getElementById("add_field_button").addEventListener( "click", function(e){

        e.preventDefault();

        if (x < max_fields) //max input box allowed
        {
          x++; //text box increment

          var div       = document.createElement('div');
          div.className = "mb-3 row";

          var str = `
            <label class="col-form-label col-md-2 text-start text-md-end" for="espec">{{ __('scarlet.label') }}: </label>
            <div class="col-md-3">
              <input type="text" class="form-control" placeholder="{{ __('scarlet.text') }}" name="label[${x}]" value="" >
            </div>
            <label class="col-form-label col-md-2 text-start text-md-end" for="desc">{{ __('scarlet.value') }}: </label>
            <div class="col-md-3">
              <input type="text" class="form-control" placeholder="{{ __('scarlet.value') }}" name="value[${x}]" value="" >
            </div>
            <div class="col-md-1" >
              <a class="btn btn-primary remove_field" href="#">
                <i class="fa fa-minus"></i>
              </a>
            </div>
          `;

          div.innerHTML = str;
          document.getElementById('input_fields_wrap').appendChild( div );

        } // if (x < max_fields)

      }); // onClick #add_field_button



      document.getElementById('type').addEventListener( "change", function(e){

        var val = this.value;

        if( val == 5 || val == 6 || val == 7 )
        {
          document.getElementById('add_options_button').classList.remove('d-none');
        }
        else
        {
          document.getElementById('add_options_button').classList.add('d-none');
          document.getElementById('input_fields_wrap').innerHTML = "";
        }

      });


      delegate(document, "click", ".remove_field", function(e) {

        e.preventDefault();
        this.parentNode.parentNode.remove();
        x--;

      });


      document.getElementById('fieldsForm').addEventListener( 'submit', function(e){

        e.preventDefault();

        var op = document.getElementById('fieldsForm').getAttribute('data-op');

        if( op == 'add' )
          add();
        else if( op == 'edt' )
          edt();

        updateTable();

        if( op == 'add' )
          clearForm();

      });


      delegate(document, "click", ".btnrem", function(e) {

        var id         = this.getAttribute( 'data-val' );
        var currentVal = JSON.parse( document.getElementById('jsonField').value );

        currentVal.splice(id, 1);

        document.getElementById('jsonField').value = JSON.stringify( currentVal );

        updateTable();
        clearForm();

      });


      document.getElementById('new').addEventListener( 'shown.bs.modal', function(){

        document.getElementById('new').setAttribute( 'data-id', '' );

        if( document.getElementById('fieldsForm').getAttribute('data-op') == 'edt' )
          clearForm();

      });


    }); // add listener - DOMContentLoaded



    var serializeForm = function (form) {

      // Setup our serialized data
      var serialized = [];

      // Loop through each field in the form
      for (var i = 0; i < form.elements.length; i++) {

        var field = form.elements[i];

        // Don't serialize fields without a name, submits, buttons, file and reset inputs, and disabled fields
        if (!field.name || field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') continue;

        // If a multi-select, get all selections
        if (field.type === 'select-multiple')
        {
          for (var n = 0; n < field.options.length; n++)
          {
            if (!field.options[n].selected) continue;

            serialized.push({ 'name' : field.name, 'value' : field.options[n].value });
          }
        }

        // Convert field data to a query string
        else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked)
        {
          serialized.push({ 'name' : field.name, 'value' : field.value });
        }
      }

      return serialized;

    };


    function add()
    {
      if( document.getElementById('jsonField').value == '' )
      {
        var newCurrent = [];
        newCurrent.push( serializeForm( document.getElementById('fieldsForm') ) );
        document.getElementById('jsonField').value = JSON.stringify( newCurrent );
      }
      else
      {
        var currentVal = JSON.parse( document.getElementById('jsonField').value );
        currentVal.push( serializeForm( document.getElementById('fieldsForm') ) );
        document.getElementById('jsonField').value = JSON.stringify( currentVal );
      }
    }


    function edt()
    {
      var currentVal = JSON.parse( document.getElementById('jsonField').value );
      var id         = document.getElementById('new').getAttribute('data-id');

      currentVal[ id ] = serializeForm( document.getElementById('fieldsForm') );

      document.getElementById('jsonField').value = JSON.stringify( currentVal );

      var myModal = new bootstrap.Modal(document.getElementById("new"), {});
      myModal.hide();
    }


    function delegate(el, evt, sel, handler)
    {
      el.addEventListener(evt, function(event) {

        var t = event.target;

        while (t && t !== this)
        {
          if (t.matches(sel))
          {
            handler.call(t, event);
          }

          t = t.parentNode;
        }

      });
    }


    function clearForm()
    {
      document.getElementById("fieldsForm").reset();
      document.getElementById("input_fields_wrap").innerHTML = null;
      document.getElementById("add_options_button").classList.add('d-none');
      document.getElementById("fieldsForm").setAttribute("data-op", 'add');
      document.querySelector('input.required[value="0"]').setAttribute("checked", "checked");
      document.querySelector('input.index[value="0"]').setAttribute("checked", "checked");
    }


    function updateTable()
    {
      // clear table
      document.querySelector('#fieldsTable tbody').innerHTML = "";

      // get input json
      var currentVal = JSON.parse( document.getElementById('jsonField').value );

      // append content into table
      currentVal.forEach(function(a, b){

        var tr  = document.createElement('tr');
        var str = '';

        str += `
          <td>${a[0]['value']}</td>
          <td>
        `;

        switch( parseInt( a[4]['value'] ) )
        {
          case 1 : str += '{{ __('scarlet.text')     }}'; break;
          case 2 : str += '{{ __('scarlet.integer')  }}'; break;
          case 3 : str += '{{ __('scarlet.double')   }}'; break;
          case 4 : str += '{{ __('scarlet.textarea') }}'; break;
          case 5 : str += '{{ __('scarlet.select')   }}'; break;
          case 6 : str += '{{ __('scarlet.radio')    }}'; break;
          case 7 : str += '{{ __('scarlet.checkbox') }}'; break;
          case 8 : str += '{{ __('scarlet.image')    }}'; break;
          case 9 : str += '{{ __('scarlet.upload')   }}'; break;
        }

        str += `
          </td>
          <td>` + (
            ( a[2]['value'] == '1' ) ?
              '<span class="text-success"><i class="fas fa-circle"  ></i></span>' :
              '<span class="text-danger" ><i class="fas fa-circle-o"></i></span>'
          ) + `
          </td>
          <td>
            <a class="btnedt text-info"   data-val="${b}" href="#"><i class="fas fa-edit"></i></a>
            <a class="btnrem text-danger" data-val="${b}" href="#"><i class="fas fa-times"></i></a>
          </td>
        `;

        tr.innerHTML = str;

        document.querySelector('#fieldsTable tbody').appendChild( tr );

      });

    } // function updateTable()



    function strpos( string, needle, offset )
    {
      var i = ( string + '' ).indexOf( needle, ( offset || 0 ) );
      return i === -1 ? false : i;
    }



  </script>

@endsection

@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('bcseo::seos.title.seos') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('bcseo::seos.title.seos') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">

            <div class="box box-primary">

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">General Setting</a></li>
                            <li class=""><a href="#sitemap" data-toggle="tab" aria-expanded="false">Sitemap</a></li>
                            <li class=""><a href="#preview" data-toggle="tab" aria-expanded="false">Social Preview</a></li>

                            <li class=""><a href="#insight" data-toggle="tab" aria-expanded="false">Insight</a></li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                {!! Form::open(['url' => route('admin.bcseo.seo.store'), 'method' => 'post']) !!}
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta Robots</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" value="{{ setting('bcseo::robots') }}" name="bcseo::robots">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Google Site Verification</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" value="{{ setting('bcseo::google-site-verifivation') }}" name="bcseo::google-site-verifivation">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Meta Locale</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" value="{{ setting('bcseo::locale') }}" name="bcseo::locale">
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Company or person</label>
                                                <p>This data is shown as metadata in your site. It is intended to appear in Google's Knowledge Graph. You can be either a company, or a person, choose either:</p>
                                                <select class="form-control " name="bcseo::company_or_person" required="">
                                                    <option value="">Choose whether you're a company or person</option>
                                                    <option value="company" {{ setting('bcseo::company_or_person') == 
                                                    'company' ? 'selected="selected"' : '' }}>Company</option>
                                                    <option value="person" {{ setting('bcseo::company_or_person') == 
                                                    'person' ? 'selected="selected"' : '' }}>Person</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                <hr>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">robots.txt</label>
                                            <textarea class="form-control" name="robots">{{ $robots }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">.htaccess</label>
                                            <textarea class="form-control" name="htaccess">{{ $htaccess }}</textarea>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>

                                </form>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="sitemap">
                                <button class="btn btn-info" id="xml-generator" data-url="{{ url('sitemap-generator') }}">Generate Sitemap</button>
                                <p>Sitemap will automaticly updated every day, so you don't need to generate manualy</p>
                                <hr>
                                <h2>Sitemap Preview</h2>
                                <iframe src="{{ url('sitemap.xml')  }}" id="xml-preview" style="width: 100%;border: none"></iframe>

                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="insight">
                                cooming soon
                            </div>
                            <div class="tab-pane" id="preview">
                                cooming soon
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('bcseo::seos.title.create seo') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.bcseo.seo.create') ?>" }
                ]
            });

            function resizeIFrameToFitContent( iFrame ) {
                iFrame.height = iFrame.contentWindow.document.body.scrollHeight;
            }

            $('#xml-preview').load(function(){
                var iFrame = document.getElementById( 'xml-preview' );
                resizeIFrameToFitContent( iFrame );
            });

            $('#xml-generator').on('click',function () {
               $(this).button('loading');
                var btn = this;
                $.ajax({
                    url: $(this).attr('data-url'),
                }).done(function() {
                    $(btn).button('reset');
                    document.getElementById('xml-preview').contentDocument.location.reload(true);
                });
            });

        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@stop

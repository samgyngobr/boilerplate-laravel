<?php

namespace Samgyngobr\Scarlet\ViewComposers;

use Config;
use Samgyngobr\Scarlet\Models\Scarlet;

class ScarletViewComposer
{
    public function compose( $view )
    {
        $view->with('listEnabledAreas', Scarlet::listEnabledAreas() );
        $view->with('skUrl'           , Config::get('app.sk_url')   );
    }
}

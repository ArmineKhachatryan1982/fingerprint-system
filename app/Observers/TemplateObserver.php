<?php

namespace App\Observers;

use App\Events\TemplateCreatedEvent;
use App\Helpers\MyHelper;
use App\Models\Person;
use App\Models\Template;

class TemplateObserver
{
    /**
     * Handle the Template "created" event.
     */
    public function created(Template $template): void
    {
        // dd($template->id);
        $person = Person::where('template', 0)
        ->with('person_permission')
        ->orderBy('id', 'desc')
        ->first();
        $templates = Template::where('people_id',$person->id)->get();
        if($templates->count() == 8){

            $person->template = 1;
            $person->save();

        }
    //    dd( count($template));
    //   dd(MyHelper::find_auth_user_client());
       event(new TemplateCreatedEvent(count($templates), userId: 1));




    }

    /**
     * Handle the Template "updated" event.
     */
    public function updated(Template $template): void
    {
        //
    }

    /**
     * Handle the Template "deleted" event.
     */
    public function deleted(Template $template): void
    {
        //
    }

    /**
     * Handle the Template "restored" event.
     */
    public function restored(Template $template): void
    {
        //
    }

    /**
     * Handle the Template "force deleted" event.
     */
    public function forceDeleted(Template $template): void
    {
        //
    }
}

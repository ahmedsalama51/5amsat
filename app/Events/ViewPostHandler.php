namespace Stidges\Events;

use Post;

class ViewPostHandler
{
    public function handle(Post $post)
    {
        // Increment the view counter by one...
        $post->increment('view_num');

        // Then increment the value on the model so that we can
        // display it. This is because the increment method
        // doesn't increment the value on the model.
        $post->view_num += 1; 
    }
}
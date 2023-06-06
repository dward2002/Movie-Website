namespace App\Cells;

class AlertMessage
{
    public function show($params): string
    {
        return "<div class="alert alert-{$params['type']}">{$params['message']}</div>";
    }
}
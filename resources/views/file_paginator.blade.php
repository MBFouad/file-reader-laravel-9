<table class="table table-striped">
    <tbody>
    @forelse ($paginator->items() as $line_num => $line)
        <tr>
            <th scope="row">{{ $line_num }}</th>
            <td>{{Str::limit($line,100,'...')}}</td>
        </tr>
    @empty
        <tr>
            <td colspan="2">No content in this file</td>
        </tr>
    @endforelse
    </tbody>
</table>
{{$paginator->links()}}

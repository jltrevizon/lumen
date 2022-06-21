
<?php
/**
 * Documentation:
 *
 * Change CSS link when uploading to production
 * Parameters:
 */

?>

<table>
    <tbody>
    @foreach($value as $d)
        <tr>
            @foreach($d as $v)
                <td>{{ $v }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
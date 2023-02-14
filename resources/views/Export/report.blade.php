<div class="title" style="padding-bottom: 13px">
    <div style="text-align: center;text-transform: uppercase;font-size: 15px">
        Wynacom Unitama Sejahtera
    </div>
    <div style="text-align: center">
        Alamat: Kelapa Gading, Jakarta Utara, Indonesia
    </div>
    <div style="text-align: center">
        Telp: 0813-1463-3490
    </div>
</div> 
<table style="width: 100%">
    <thead>
        <tr  style="background-color: #e6e6e7;">
            @foreach ($filter['headers'] as $header)
                <th scope="col">{{ $header->field_description }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($filter['data'] as $d)
        <tr>
            @foreach ($filter['headers'] as $header)
            <?php $fields = $header->field_name ?>
                <td>{{ $d->$fields }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
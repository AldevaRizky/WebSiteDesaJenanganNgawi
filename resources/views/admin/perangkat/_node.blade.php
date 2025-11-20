<li>
    <div class="node-box">
        @if($node->gambar)
            <div class="photo"><img src="{{ $node->gambar_url }}" alt="{{ $node->nama }}"></div>
        @else
            @php
                $parts = preg_split('/\s+/', trim($node->nama));
                $initials = '';
                foreach($parts as $p) { $initials .= mb_strtoupper(mb_substr($p,0,1)); if(mb_strlen($initials) >= 2) break; }
            @endphp
            <div class="initials">{{ $initials }}</div>
        @endif

        <div class="info">
            <div class="name"><strong>{{ $node->nama }}</strong></div>
            <div class="divider"></div>
            <div class="jabatan">{{ $node->jabatan }}</div>
        </div>
    </div>

    @if($node->children && $node->children->count())
        <ul class="children">
            @foreach($node->children as $child)
                @include('admin.perangkat._node', ['node' => $child])
            @endforeach
        </ul>
    @endif
</li>

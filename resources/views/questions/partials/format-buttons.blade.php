<div style="">
    <button type="button" style="margin-right: 15px;" class="btn-format" onclick="wrapText('{{ $textarea }}', '**', '**', 'bold text')">B</button>
    <button type="button" style="margin-right: 15px;" class="btn-format" onclick="wrapText('{{ $textarea }}', '*', '*', 'italic text')">I</button>
    <button type="button" style="margin-right: 15px;" class="btn-format" onclick="wrapText('{{ $textarea }}', '[', '](http://example.com)', 'anchor')">L</button>
    <button type="button" style="margin-right: 15px;" class="btn-format" onclick="wrapText('{{ $textarea }}', '#', '', 'Heading')">H1</button>
    <button type="button" style="margin-right: 15px;" class="btn-format" onclick="wrapText('{{ $textarea }}', '##', '', 'Heading')">H2</button>
</div>

<div class="flex items-center gap-4 mb-4">
    <label for="chartType" class="font-semibold">Tipe Chart:</label>
    <select id="chartType" class="border rounded px-2 py-1" onchange="window.location.search='?chart_type='+this.value">
        <option value="bar" {{ $chartType === 'bar' ? 'selected' : '' }}>Diagram Batang</option>
        <option value="pie" {{ $chartType === 'pie' ? 'selected' : '' }}>Diagram Lingkaran</option>
    </select>
</div>
@parent

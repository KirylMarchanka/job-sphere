<form action="{{ route('employers.index') }}" class="mb-3">
    <div class="form-group">
        <label class="mb-1" for="name">Наименование:</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="Поиск по наименованию"
               value="{{ $name }}">
    </div>
    <div class="form-group">
        <label class="my-1" for="sector">Сектор:</label>
        <select name="sector" id="sector" class="form-select">
            <option value="">Любой</option>
            @foreach ($sectors as $sectorData)
                <option
                    @selected($sectorData['id'] == $sector) value="{{ $sectorData['id'] }}">{{ $sectorData['name'] }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success mt-2">Найти</button>
</form>

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cargo;

class Cargos extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre, $descripción, $salario, $empleado_id;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.cargos.view', [
            'cargos' => Cargo::latest()
						->orWhere('nombre', 'LIKE', $keyWord)
						->orWhere('descripción', 'LIKE', $keyWord)
						->orWhere('salario', 'LIKE', $keyWord)
						->orWhere('empleado_id', 'LIKE', $keyWord)
						->paginate(10),
        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->nombre = null;
		$this->descripción = null;
		$this->salario = null;
		$this->empleado_id = null;
    }

    public function store()
    {
        $this->validate([
		'nombre' => 'required',
		'descripción' => 'required',
		'salario' => 'required',
		'empleado_id' => 'required',
        ]);

        Cargo::create([ 
			'nombre' => $this-> nombre,
			'descripción' => $this-> descripción,
			'salario' => $this-> salario,
			'empleado_id' => $this-> empleado_id
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Cargo Successfully created.');
    }

    public function edit($id)
    {
        $record = Cargo::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombre = $record-> nombre;
		$this->descripción = $record-> descripción;
		$this->salario = $record-> salario;
		$this->empleado_id = $record-> empleado_id;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombre' => 'required',
		'descripción' => 'required',
		'salario' => 'required',
		'empleado_id' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Cargo::find($this->selected_id);
            $record->update([ 
			'nombre' => $this-> nombre,
			'descripción' => $this-> descripción,
			'salario' => $this-> salario,
			'empleado_id' => $this-> empleado_id
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Cargo Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Cargo::where('id', $id);
            $record->delete();
        }
    }
}

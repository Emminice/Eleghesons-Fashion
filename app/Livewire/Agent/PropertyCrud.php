<?php

namespace App\Livewire\Agent;

use Livewire\Component;
use App\Models\Property;
use Illuminate\Support\Str;
// use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class PropertyCrud extends Component
{
    use WithFileUploads; 

    // public function loadProperties()
    // {
    //     $this->properties = 
    //     Property::where('agent_id', auth()->id())->latest()->get();
    // }

    public $properties;
    public $propertyId;
    public $title;
    public $description;
    public $location;
    public $price;
    public $beds;
    public $baths;
    public $area;
    public $images = [];
    public $existingImages = [];
    public $features = [];

    public $mainImageIndex = 0;

    public $modalFormVisible = false;
    public $isEditMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric',
        'beds' => 'required|integer|min:0',
        'baths' => 'required|integer|min:0',
        'area' => 'nullable|string|max:255',
        'images.*' => 'image|max:4096', // 1MB max per image (4MB for all images (4))
    ];

    public function mount()
    {
        $this->loadProperties();
    }

    protected $listeners = [
        'property-status-updated' => 'loadProperties',
    ];
    
    public function loadProperties()
    {
        $this->properties = Property::where('agent_id', auth()->id())
        ->whereIn('status', ['pending', 'approved'])
            ->latest()->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->modalFormVisible = true;
        $this->isEditMode = false;
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);

        if ($property->status !== 'pending') {
            return;
        }

        $this->resetForm();
        $this->propertyId = $id;
        $property = Property::findOrFail($id);

        $this->title = $property->title;
        $this->description = $property->description;
        $this->location = $property->location;
        $this->price = $property->price;
        $this->beds = $property->beds;
        $this->baths = $property->baths;
        $this->area = $property->area;
        $this->existingImages = $property->images ?? [];
        $this->features = $property->features ?? [];

        $this->modalFormVisible = true;
        $this->isEditMode = true;
    }

    public function save()
    {
        $this->validate([
            'images' => 'required|array|min:4|max:4',
            'images.*' => 'image|max:4096',
        ]);
        
        $uploadedImages = [];

        foreach($this->images as $image) {
            $path = $image->store('properties', 'public');
            $uploadedImages[] = '/storage/' . $path;
        }

        $mainImage = $uploadedImages[$this->mainImageIndex];
        unset($uploadedImages[$this->mainImageIndex]);

        $uploadedImages = array_values($uploadedImages);
        array_unshift($uploadedImages, $mainImage);

        // if ($this->images) {
        //     foreach ($this->images as $image) {
        //         $path = $image->store('properties', 'public');
        //         $uploadedImages[] = '/storage/' . $path;
        //     }
        // }

        $data = [
            'agent_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'price' => $this->price,
            'beds' => $this->beds,
            'baths' => $this->baths,
            'area' => $this->area,
            // 'images' => array_merge($this->existingImages, $uploadedImages),
            'images' => $uploadedImages, // first image is main, rest are secondary
            'features' => $this->features,
        ];

        if (! $this->isEditMode) {
            $data['status'] = 'pending';
        }

        if ($this->isEditMode) {
            Property::findOrFail($this->propertyId)->update($data);
        } else {
            Property::create($data);
        }

        $this->modalFormVisible = false;
        $this->resetForm();
        $this->loadProperties();
    }

    public function delete($id)
    {
        Property::findOrFail($id)->delete();
        $this->loadProperties();
    }

    private function resetForm()
    {
        $this->propertyId = null;
        $this->title = '';
        $this->description = '';
        $this->location = '';
        $this->price = '';
        $this->beds = 0;
        $this->baths = 0;
        $this->area = '';
        $this->images = [];
        $this->existingImages = [];
        $this->features = [];
    }

    public function render()
    {
        return view('livewire.agent.property-crud')
            ->layout('layouts.app');
    }
}

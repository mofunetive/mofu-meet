 <a href={{ $path }}>
     <div
         class="{{ request()->routeIs($path) ? 'bg-gray-100' : '' }} flex gap-2 items-center cursor-pointer hover:bg-gray-200 hover:transition-all p-2 rounded-lg">
         {{ $slot }}
         <p>{{ ucfirst($path) }}</p>
     </div>
 </a>

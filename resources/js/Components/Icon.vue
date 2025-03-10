<template>
    <svg 
        :width="size" 
        :height="size" 
        viewBox="0 0 24 24" 
        :class="computedClass"
        fill="none" 
        xmlns="http://www.w3.org/2000/svg"
        role="img"
        :aria-label="name"
        stroke="currentColor"
    >
        <title v-if="showTitle">{{ name }}</title>
        
        <!-- Check Icon -->
        <path v-if="name === 'check' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M5 13l4 4L19 7" 
        />
        <path v-if="name === 'check' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" 
            clip-rule="evenodd" 
        />
        
        <!-- User Icon -->
        <path v-if="name === 'user' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" 
        />
        <path v-if="name === 'user' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" 
            clip-rule="evenodd" 
        />
        
        <!-- Document Icon -->
        <path v-if="name === 'document' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" 
        />
        <path v-if="name === 'document' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" 
            clip-rule="evenodd" 
        />
        
        <!-- Search Icon -->
        <path v-if="name === 'search' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" 
        />
        <path v-if="name === 'search' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" 
            clip-rule="evenodd" 
        />
        
        <!-- Map Pin Icon -->
        <template v-if="name === 'map-pin' && !solid">
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" 
            />
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" 
            />
        </template>
        <path v-if="name === 'map-pin' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M5.05 4.05a7 7 0 119.9 9.9l-4.95 4.95a.999.999 0 01-1.414 0l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" 
            clip-rule="evenodd" 
        />
        
        <!-- Bell Icon -->
        <path v-if="name === 'bell' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" 
        />
        <path v-if="name === 'bell' && solid" 
            fill="currentColor"
            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" 
        />
        
        <!-- Download Icon -->
        <path v-if="name === 'download' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" 
        />
        <path v-if="name === 'download' && solid" 
            fill="currentColor"
            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" 
        />
        
        <!-- Text Icon -->
        <path v-if="name === 'text' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M4 6h16M4 12h16M4 18h7" 
        />
        <path v-if="name === 'text' && solid" 
            fill="currentColor"
            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 6a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 6a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1z" 
        />
        
        <!-- Shield Icon -->
        <path v-if="name === 'shield' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" 
        />
        <path v-if="name === 'shield' && solid" 
            fill="currentColor"
            d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" 
        />
        
        <!-- Fast Icon (Lightning Bolt) -->
        <path v-if="name === 'fast' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M13 10V3L4 14h7v7l9-11h-7z" 
        />
        <path v-if="name === 'fast' && solid" 
            fill="currentColor"
            d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" 
        />
        
        <!-- Device Mobile Icon -->
        <path v-if="name === 'device-mobile' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" 
        />
        <path v-if="name === 'device-mobile' && solid" 
            fill="currentColor"
            d="M8 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H8zm0 14V4h8v12H8z" 
        />
        
        <!-- Storage Icon (Database) -->
        <path v-if="name === 'storage' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" 
        />
        <path v-if="name === 'storage' && solid" 
            fill="currentColor"
            d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" 
        />
        
        <!-- Document PDF Icon -->
        <path v-if="name === 'document-pdf' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z M10 10.5a1.5 1.5 0 00-1.5 1.5v3a1.5 1.5 0 003 0v-3a1.5 1.5 0 00-1.5-1.5zm5 0a1.5 1.5 0 00-1.5 1.5v3a1.5 1.5 0 003 0v-3a1.5 1.5 0 00-1.5-1.5z" 
        />
        <path v-if="name === 'document-pdf' && solid" 
            fill="currentColor"
            d="M7 3a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V7.414A2 2 0 0018.414 6L14 1.586A2 2 0 0012.586 1H7zm0 6a1 1 0 011-1h.01a1 1 0 110 2H8a1 1 0 01-1-1zm9 3a1 1 0 01-1 1h-2a1 1 0 110-2h2a1 1 0 011 1zm-8 2a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1zm9 0a1 1 0 01-1 1h-2a1 1 0 110-2h2a1 1 0 011 1z" 
        />
        
        <!-- Photograph Icon -->
        <path v-if="name === 'photograph' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" 
        />
        <path v-if="name === 'photograph' && solid" 
            fill="currentColor"
            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" 
        />
        
        <!-- Chevron Down Icon -->
        <path v-if="name === 'chevron-down' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M19 9l-7 7-7-7" 
        />
        <path v-if="name === 'chevron-down' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
            clip-rule="evenodd" 
        />
        
        <!-- Chevron Right Icon -->
        <path v-if="name === 'chevron-right' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M9 5l7 7-7 7" 
        />
        <path v-if="name === 'chevron-right' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" 
            clip-rule="evenodd" 
        />
        
        <!-- Mail Icon -->
        <path v-if="name === 'mail' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" 
        />
        <path v-if="name === 'mail' && solid" 
            fill="currentColor"
            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884zM18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" 
        />
        
        <!-- Chevron Left Icon -->
        <path v-if="name === 'chevron-left' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M15 19l-7-7 7-7" 
        />
        <path v-if="name === 'chevron-left' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" 
            clip-rule="evenodd" 
        />
        
        <!-- Chevron Right Icon -->
        <path v-if="name === 'chevron-right' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M9 5l7 7-7 7" 
        />
        <path v-if="name === 'chevron-right' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" 
            clip-rule="evenodd" 
        />
        
        <!-- Pencil Icon -->
        <path v-if="name === 'pencil' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" 
        />
        <path v-if="name === 'pencil' && solid" 
            fill="currentColor"
            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" 
        />
        
        <!-- Duplicate Icon -->
        <path v-if="name === 'duplicate' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" 
        />
        <path v-if="name === 'duplicate' && solid" 
            fill="currentColor"
            d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z"
        />
        <path v-if="name === 'duplicate' && solid" 
            fill="currentColor"
            d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h8a2 2 0 00-2-2H5z"
        />
        
        <!-- Document Text Icon -->
        <path v-if="name === 'document-text' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" 
        />
        <path v-if="name === 'document-text' && solid" 
            fill="currentColor"
            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
        />

        <!-- Trash Icon -->
        <path v-if="name === 'trash' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" 
        />
        <path v-if="name === 'trash' && solid" 
            fill="currentColor"
            fill-rule="evenodd"
            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
            clip-rule="evenodd"
        />

        <!-- Collection Icon -->
        <path v-if="name === 'collection' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" 
        />
        <path v-if="name === 'collection' && solid" 
            fill="currentColor"
            d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"
        />

        <!-- Template Icon -->
        <path v-if="name === 'template' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" 
        />
        <path v-if="name === 'template' && solid" 
            fill="currentColor"
            d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
        />

        <!-- Code Icon -->
        <path v-if="name === 'code' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" 
        />
        <path v-if="name === 'code' && solid" 
            fill="currentColor"
            fill-rule="evenodd"
            d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z"
            clip-rule="evenodd"
        />

        <!-- Support Icon -->
        <path v-if="name === 'support' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" 
        />
        <path v-if="name === 'support' && solid" 
            fill="currentColor"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z"
        />

        <!-- Shield Check Icon -->
        <path v-if="name === 'shield-check' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" 
        />
        <path v-if="name === 'shield-check' && solid" 
            fill="currentColor"
            d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" 
        />

        <!-- Credit Card Icon -->
        <path v-if="name === 'credit-card' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" 
        />
        <path v-if="name === 'credit-card' && solid" 
            fill="currentColor"
            d="M4 4a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6h8a1 1 0 100-2H6a1 1 0 000 2zm0 3h4a1 1 0 100-2H6a1 1 0 000 2z"
        />

        <!-- Question Mark Circle Icon -->
        <path v-if="name === 'question-mark-circle' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" 
        />
        <path v-if="name === 'question-mark-circle' && solid" 
            fill="currentColor"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
        />

        <!-- X Icon -->
        <path v-if="name === 'x' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M6 18L18 6M6 6l12 12" 
        />
        <path v-if="name === 'x' && solid" 
            fill="currentColor"
            fill-rule="evenodd"
            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
            clip-rule="evenodd"
        />
        
        <!-- Document Download Icon -->
        <path v-if="name === 'document-download' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" 
        />
        <path v-if="name === 'document-download' && solid" 
            fill="currentColor"
            d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
        />
        
        <!-- Fallback pour les icônes non définies -->
        <g v-if="!hasIcon">
            <rect width="24" height="24" fill="none" stroke="currentColor" stroke-width="1" rx="4"></rect>
            <text x="12" y="16" font-size="8" text-anchor="middle" fill="currentColor">{{ name }}</text>
        </g>
    </svg>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    name: {
        type: String,
        required: true
    },
    size: {
        type: [Number, String],
        default: 24
    },
    color: {
        type: String,
        default: 'currentColor'
    },
    solid: {
        type: Boolean,
        default: false
    },
    customClass: {
        type: String,
        default: ''
    },
    showTitle: {
        type: Boolean,
        default: false
    }
});

// Classes CSS calculées
const computedClass = computed(() => {
    return [
        'icon',
        `icon-${props.name}`,
        {
            'icon-solid': props.solid,
        },
        props.customClass
    ];
});

// Vérifie si l'icône existe
const hasIcon = computed(() => {
    const iconName = props.name.toLowerCase();
    return [
        'check', 'user', 'document', 'search', 'map-pin', 'bell', 'chevron-down', 
        'chevron-right', 'chevron-left', 'mail', 'download', 'text', 'shield', 
        'fast', 'device-mobile', 'storage', 'document-pdf', 'photograph',
        'pencil', 'duplicate', 'document-text', 'trash', 'collection', 'template',
        'code', 'support', 'shield-check', 'credit-card', 'question-mark-circle', 'x',
        'document-download'
    ].includes(iconName);
});
</script>

<style>
.icon {
    display: inline-block;
    stroke: currentColor;
    fill: none;
    vertical-align: middle;
    transition: transform 0.2s ease;
}

.icon-solid {
    fill: currentColor;
    stroke: none;
}

.icon.spin {
    animation: spin 1s linear infinite;
}

.icon.pulse {
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
}
</style>

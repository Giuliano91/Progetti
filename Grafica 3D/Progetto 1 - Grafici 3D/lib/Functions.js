/* SCENE SETUP FUNCTIONS */

function animate() {
    controls.update();
    wakeUpCamera();
    onWindowResize();
    requestAnimationFrame(animate);   
}

function render() {     
    renderer.render(scene, camera);    
}

// This functions keep the proportions of the rendered scene on window resize

function onWindowResize(){
    renderer.setSize( window.innerWidth, window.innerHeight );
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();    
}

/* This function moves the camera, because when new data are generated and a new is made; to view the changes, the camera has to
move.*/

function wakeUpCamera() {
    camera.position.x+=0.0000000001;
}

// This function shows an intro text with the instructions to use the application

function showIntroText() {
    
    var introText, introText2, introText3, introText4, introText5, introText6, introTextGeometry, introTextGeometry2,
        introTextGeometry3, introTextGeometry4, introTextGeometry5, introTextGeometry6, introTextMaterial, text, text2, text3,
        text4, text5, text6;
    
    scene = new THREE.Scene();
    
    introText = "Instructions: 1) Select a type of chart. After that, more controls will be shown.";
    introText2 = "2) Select a color set, if you want.";
    introText3 = "3) Edit data.";
    introText4 = "4) You can highlight data by clicking over it";
    introText5 = "5) You can remove the highlight by clicking the reset button";
    introText6 = "Made by: Soprano Michael - Perazza Giuliano";
    
    introTextGeometry = new THREE.TextGeometry( introText, {size: 6.3,height: 0.5,curveSegments:2,font: "helvetiker"});
    introTextGeometry2 = new THREE.TextGeometry( introText2, {size: 6.3,height: 0.5,curveSegments:2,font: "helvetiker"});
    introTextGeometry3 = new THREE.TextGeometry( introText3, {size: 6.3,height: 0.5,curveSegments:2,font: "helvetiker"});
    introTextGeometry4 = new THREE.TextGeometry( introText4, {size: 6.3,height: 0.5,curveSegments:2,font: "helvetiker"});
    introTextGeometry5 = new THREE.TextGeometry( introText5, {size: 6.3,height: 0.5,curveSegments:2,font: "helvetiker"});
    introTextGeometry6 = new THREE.TextGeometry( introText6, {size: 6.3,height: 0.5,curveSegments:2,font: "helvetiker"});
    introTextMaterial = new THREE.MeshBasicMaterial( { color: 0xF52BA, overdraw: true } );
    
    text = new THREE.Mesh( introTextGeometry, introTextMaterial );   
    text2 = new THREE.Mesh( introTextGeometry2, introTextMaterial );
    text3 = new THREE.Mesh( introTextGeometry3, introTextMaterial );
    text4 = new THREE.Mesh( introTextGeometry4, introTextMaterial );
    text5 = new THREE.Mesh( introTextGeometry5, introTextMaterial );
    text6 = new THREE.Mesh( introTextGeometry6, introTextMaterial );
    
    text.position.x = -152;
    text2.position.y = -10;
    text2.position.x = -103; 
    text3.position.y = -20;
    text3.position.x = -103; 
    text4.position.y = -30;
    text4.position.x = -103;
    text5.position.y = -40;
    text5.position.x = -103;
    text6.position.y = -60;
    text6.position.x = -152; 
    
    rowsNumber.onChange(function(value) {
        showIntroText();
    });
    
    columnsNumber.onChange(function(value) {          
        showIntroText();
    });
    
    maxValue.onChange(function(value) { 
        showIntroText();
    });
    
    scene.add(text);
    scene.add(text2); 
    scene.add(text3);
    scene.add(text4);
    scene.add(text5);
    scene.add(text6);
    
    camera.position.z = 100;
}            

/* DATA SETUP FUNCTIONS */

// This function generates a matrix of random integers to use as data for the graphs

function generateData(rowNumb , colNumb, min, max) {    
    
    var data = new Array();
    var tempArray;
    
    for(var i=0;i<rowNumb;i++){
        tempArray = new Array();
        for (var j=0;j<colNumb;j++) {
            // The random values are rounded to the second decimal digit         
            tempArray.push(Math.round((Math.random() * (max - min) + min)*100)/100);
        }
        data.push(tempArray);        
    }
    return data;
 }

/* COLOR SETUP FUNCTIONS */

// This function loads the selected color set within the selected type of chart

function loadChartColor() {
    
    scene = new THREE.Scene();
    
    colorSet.onChange(function(value) {        
        switch (params.Color_Set) {
            // If the first set is chosen
            case 'Set 1':
                colors = new Array();
                colors.push(0x00ff00);
                colors.push(0xffff00);
                colors.push(0xFF0049);
                colors.push(0x0E28E8);
                colors.push(0x4B0082);
                colors.push(0x30D5C8);       
            break;
            // If the second set is chosen
            case 'Set 2': 
                colors = new Array();                
                colors.push(0x0F52BA);
                colors.push(0xFF6600); 
                colors.push(0xffd800);
                colors.push(0xC0007F);
                colors.push(0xFF0000);                
                colors.push(0x410012);                           
            break;
        }     
        switch (params.Chart){
            case 'Pie Chart':
                showPieChart();                          
            break;
            case 'Bar Chart':
                showBarChart();               
            break;
			case 'Area Chart':
                showAreaChart();               
            break;                 
        }              
    });
    // Now, colors is an array that contains the colors of the chosen set. 
}

// This function loads the highlight feature for the graphs

function loadHighlight() {
    
    var raycaster, intersects, intersectedMesh, chart; 
    
    projector = new THREE.Projector();
    mouseVector = new THREE.Vector3();
    
    // Window listener to detect mouse click
    window.addEventListener( 'click', onMouseClick, false );
    
    function onMouseClick( e ) {
        
        // The mouse coordinates are obtained
        mouseVector.x = 2 * (e.clientX / window.innerWidth) - 1;
        mouseVector.y = 1 - 2 * ( e.clientY / window.innerHeight );
        
        // Here a ray that goes from the camera to the mouse coordinates is made
        raycaster = projector.pickingRay( mouseVector.clone(), camera );
        // Here we get the meshes intersected by the ray
        intersects = raycaster.intersectObjects( chartMesh.children );
        
        // If there are intersected meshes
        if(intersects.length>0) {
       
            // We get the nearest mesh. That array goes from 0..n, the n-th mesh is furthest.
            intersectedMesh = intersects[ 0 ]; 
            chart = intersectedMesh.object;

            // If it's highlighted
            if(chart.material.opacity==0.65){              
                chart.material.opacity = 1;            
            }            
        } 
    }
}

/* PLANE SETUP FUNCTIONS */

// This function generates three planes centered in (0,0,0) point

function generatePlanes(data,maxValue) {
  
    var planeXYGeometry, planeXYMesh, planeMaterial, planeXZMaterial;
    var planeXZGeometry, planeXZMesh;
    var planeYZGeometry, planeYZMesh;
    var planeXZ, planeYZ, planeXY;
        
    planeMaterial = new THREE.MeshBasicMaterial({color:0xa0a0a0,side:THREE.DoubleSide,opacity:0.65,transparent: true});    
    planeXZMaterial = new THREE.MeshBasicMaterial({color:0x808080,side:THREE.DoubleSide});
    
    // XY PLANE : Width = Row Number, Height: Max Value
    planeXYGeometry = new THREE.PlaneGeometry(data.length*2,maxValue);    
    planeXYMesh = new  THREE.Mesh(planeXYGeometry,planeMaterial);
    
    // XZ PLANE: Width = Row Number, Height: Column Number
    planeXZGeometry = new THREE.PlaneGeometry(data.length*2,data[0].length*2);    
    planeXZMesh = new  THREE.Mesh(planeXZGeometry,planeXZMaterial);
    
    // YZ PLANE: Width = Column Number, Height: Max Value
    planeYZGeometry = new THREE.PlaneGeometry(data[0].length*2,maxValue);    
    planeYZMesh = new  THREE.Mesh(planeYZGeometry,planeMaterial);    
    
    // There are some roto-translations that are applied to the planes
    
    planeXYMesh.position.x = (data.length);
    planeXYMesh.position.y = maxValue/2;
    planeXZMesh.rotation.x = -90*Math.PI/180;
    planeXZMesh.position.x = (data.length);
    planeXZMesh.position.z = (data[0].length);
    planeYZMesh.rotation.y = 90*Math.PI/180;
    planeYZMesh.position.y = maxValue/2;
    planeYZMesh.position.z = data[0].length;
    
    planeXZ = new THREE.Object3D();
    planeXZ.add(planeXZMesh);
    planeXY = new THREE.Object3D();
    planeXY.add(planeXYMesh);
    planeYZ = new THREE.Object3D();
    planeYZ.add(planeYZMesh);
    
    scene.add(planeXY);
    scene.add(planeYZ);
    scene.add(planeXZ);    
    
}

/* PIE CHART FUNCTIONS */

/* This function generates a pie chart mesh. It takes as input the random data generated, 
the color set chosen from the user, and the row tho show */

function generatePieChart(data, colorSet, rowToShow) {
    
    var pieGeometry, pieMaterial, chartMesh, chart, pVertices, tot, sumRotation, ray, sumVertices; 
    
    chartMesh = new THREE.Object3D();
    
    tot = 0;
    sumRotation = 0;
    ray = 14;
    sumVertices = 0;
    pVertices = new Array(data.length);
    
    // Sum all the value of the row to show
    for(var i = 0; i < data[rowToShow-1].length;i++){
        tot += data[rowToShow-1][i];
    }
    
    // Compute the number of vertices for each slice
    for(var i = 0; i < pVertices.length;i++){
        pVertices[i] = Math.round((data[rowToShow-1][i]*(360))/tot);
        sumVertices += pVertices[i];
        
        /* If the sum of all slice vertices is greater or lesser than 360°,
        the last slice's number of vertices is reduced or increased*/
        if(i == pVertices.length - 1 && (sumVertices < 360 || sumVertices > 360)) {
            pVertices[i] = 360 - (sumVertices - pVertices[i]);
        }
    }

    for(var i = 0; i < data[rowToShow-1].length;i++){

        pieGeometry = new THREE.Geometry();
        // The pie is created with the color assigned to the current row, for every slice
        pieMaterial = new THREE.MeshBasicMaterial( { color: colorSet[i], side:THREE.FrontSide, opacity: 0.65,transparent: true});
        
        // Central vertices are pushed in the geometry
        pieGeometry.vertices.push( new THREE.Vector3(0,2,0));
        pieGeometry.vertices.push( new THREE.Vector3(0,0,0));
        
        for(var j=0;j<=pVertices[i];j++){
            // The vertices along the circumference are pushed in the geometry
            pieGeometry.vertices.push( new THREE.Vector3( Math.cos(j*Math.PI/180)*ray, 2, Math.sin(j*Math.PI/180)*ray));
            pieGeometry.vertices.push( new THREE.Vector3( Math.cos(j*Math.PI/180)*ray, 0, Math.sin(j*Math.PI/180)*ray));     
        }

        for(var j=2;j< pieGeometry.vertices.length-2;j= j+2){
            // Top faces are created
            pieGeometry.faces.push( new THREE.Face3( 0, j+2, j ));
            // Bottom faces are created
            pieGeometry.faces.push( new THREE.Face3( 1, j+1, j+3));
            // Lateral faces are created
            pieGeometry.faces.push( new THREE.Face3( j+1,j, j+2));
            pieGeometry.faces.push( new THREE.Face3( j+2, j+3, j+1));
        }
         
        chart = new THREE.Mesh(pieGeometry,pieMaterial);
        
        // Sum the grades of the i-th slice
        sumRotation += (pVertices[i])*Math.PI/180;

        chart.rotation.y = sumRotation;
        chartMesh.add(chart);
    }
    
    // Finally, the mesh is ready to be shown
    return chartMesh;   
}   

// This function updates the pie chart if there are changes in the GUI.

function showPieChart() {   
    
    /* PIE CHART SETUP */ 
    
    scene = new THREE.Scene();    
    
    // If the number of rows changes, a new matrix is calculated
    rowsNumber.onChange(function(value) {
        // Row to show param should not be greater than the number of rows.
        rowToShow.max(params.Rows); 
        // The old data are deleted
        data = new Array();
        // New data are made
        data = generateData(params.Rows, params.Columns,1,params.Max_Value);
        scene = new THREE.Scene(); 
        // The pie mesh for the data is ready
        chartMesh = generatePieChart(data,colors,params.Row_To_Show);
        scene.add(chartMesh);
    });
    
    // The key idea is the same as the row number
    columnsNumber.onChange(function(value) {  
        data = new Array();
        data = generateData(params.Rows, params.Columns,1,params.Max_Value);
        scene = new THREE.Scene(); 
        chartMesh = generatePieChart(data,colors,params.Row_To_Show);
        scene.add(chartMesh);
    });
    
    // The key idea is the same as the row number
    maxValue.onChange(function(value) { 
        data = new Array();
        data = generateData(params.Rows, params.Columns,1,params.Max_Value);
        scene = new THREE.Scene(); 
        chartMesh = generatePieChart(data,colors,params.Row_To_Show);
        scene.add(chartMesh);
    });
    
    // If the aren't changes the pie chart is loaded with default data
    chartMesh = generatePieChart(data,colors,1);
    scene.add(chartMesh);
    
    // If the row to show changes, there's no need to create data matrix again.
    rowToShow.onChange(function(value) { 
        scene = new THREE.Scene(); 
        chartMesh = generatePieChart(data,colors,params.Row_To_Show);
        scene.add(chartMesh);
    });  
}

/* BAR CHART FUNCTIONS */

/* This function generates a bar chart mesh with xy, xz, yz planes. It takes as input the random data generated, 
the color set chosen from the user, and the max value of data matrix */ 

function generateBarChart(data, colorSet, maxValue) {
    
    var barGeometry, barMaterial, chart, chartMesh;
    
    // Planes for the graph are loaded
    generatePlanes(data,maxValue);
    
    chartMesh = new THREE.Object3D();    
    barGeometry = new THREE.CubeGeometry(0.5,1,0.5);

    for(var i=0;i<data.length;i++){        
      
        for(var j=0;j<data[i].length;j++){   
            
            // The material is created with the color of the color set assigned to the current row
            barMaterial = new THREE.MeshBasicMaterial({color:colorSet[i], side:THREE.FrontSide,opacity: 0.65,transparent: true});
            
            chart = new THREE.Mesh(barGeometry,barMaterial);          
            chart.position.z = j*2+1;
            chart.position.x = i*2+1;
            chart.position.y = data[i][j]/2 + 0.005;
            chart.scale.y = data[i][j];
        
            chartMesh.add(chart);         
        }
    }
    return chartMesh;
}

function showBarChart() {   
    
    /* BAR CHART SETUP */
    
    scene = new THREE.Scene();    
    
    // If the number of rows changes, a new matrix is calculated
    rowsNumber.onChange(function(value) {    
        // The old data are deleted
        data = new Array();
        // New data are made
        data = generateData(params.Rows, params.Columns,1,params.Max_Value);
        scene = new THREE.Scene(); 
        // The bar mesh for the data is ready
        chartMesh = generateBarChart(data,colors,params.Max_Value);
        scene.add(chartMesh);
    });
    
    // The key idea is the same as the row number
    columnsNumber.onChange(function(value) {  
        data = new Array();
        data = generateData(params.Rows, params.Columns,1,params.Max_Value);
        scene = new THREE.Scene(); 
        chartMesh = generateBarChart(data,colors,params.Max_Value);
        scene.add(chartMesh);
    });
    
    // The key idea is the same as the row number
    maxValue.onChange(function(value) {  
        data = new Array();
        data = generateData(params.Rows, params.Columns,1,params.Max_Value);
        scene = new THREE.Scene(); 
        chartMesh = generateBarChart(data,colors,params.Max_Value);
        scene.add(chartMesh);
    });
     
    // If the aren't changes the bar chart is loaded with default data
    chartMesh = generateBarChart(data,colors,params.Max_Value);
    scene.add(chartMesh);
}

/* AREA CHART FUNCTIONS */

/* This function generates an area chart mesh with xy, xz, yz planes. It takes as input the random data generated, 
the color set chosen from the user, and the max value of data matrix */ 

function generateAreaChart(data, colorSet, maxValue) {    

    var areaGeometry, areaMaterial, chartMesh, chart;
    
    // Planes for the graph are loaded
    generatePlanes(data,maxValue);
    
    chartMesh = new THREE.Object3D();
   
    for(var i=0;i<data.length;i++){
        areaGeometry = new THREE.Geometry();
        // The area is created with the color assigned to the current row, for every row
        areaMaterial = new THREE.MeshBasicMaterial({color:colorSet[i], side:THREE.FrontSide,opacity: 0.65,
                                                    blendSrc:THREE.SrcAlphaFactor,
                                                    blendDst: THREE.OneMinusSrcAlphaFactor,
                                                    blendEquation: THREE.AddEquation,
                                                    transparent: true});
        // Blending is activated because of a problem with depth test.
        
        for(var j=0;j<data[i].length;j++){
            // Here the vertices for the front face are pushed
            areaGeometry.vertices.push(new THREE.Vector3(i*2,data[i][j],j*2));
            areaGeometry.vertices.push(new THREE.Vector3(i*2,0,j*2));                
        }
        for(var j=data[i].length-1;j>=0;j--){
            // Here the vertices for the back face are pushed
            areaGeometry.vertices.push(new THREE.Vector3(i*2-0.5,data[i][j],j*2));
            areaGeometry.vertices.push(new THREE.Vector3(i*2-0.5,0,j*2));
        }

        for(var k=0;k<areaGeometry.vertices.length-2;k= k+2){
			// Here the front and back faces of the area chart are made
            areaGeometry.faces.push(new THREE.Face3(k+2,k+1,k));
            areaGeometry.faces.push(new THREE.Face3(k+3,k+1,k+2));
			// Here the top face of the area chart is made
			areaGeometry.faces.push(new THREE.Face3(areaGeometry.vertices.length-2-k,k+2,k));
        }
		// Here the first triangle of the last lateral face is made
        areaGeometry.faces.push(new THREE.Face3(0,areaGeometry.vertices.length -1,areaGeometry.vertices.length -2));
        // Here the second triangle of the last lateral face is made
        areaGeometry.faces.push(new THREE.Face3(1,areaGeometry.vertices.length -1,0));
     
        chart = new THREE.Mesh(areaGeometry,areaMaterial);
        chart.position.x = 1.2;
        chart.position.z = 1.2;
        
        chartMesh.add(chart);    
    }    
   
    return chartMesh;
}

function showAreaChart() {   
    
    /* AREA CHART SETUP */
    
    scene = new THREE.Scene();  

    // If the number of rows changes, a new matrix is calculated
    rowsNumber.onChange(function(value) {    
        // The old data are deleted
        data = new Array();
        // New data are made
        data = generateData(params.Rows, params.Columns,1,params.Max_Value);
        scene = new THREE.Scene(); 
        // The area mesh for the data is ready
        chartMesh = generateAreaChart(data,colors,params.Max_Value);
        scene.add(chartMesh);
    });
    
    // The key idea is the same as the row number
    columnsNumber.onChange(function(value) {  
        data = new Array();
        data = generateData(params.Rows, params.Columns,1,params.Max_Value);
        scene = new THREE.Scene(); 
        chartMesh = generateAreaChart(data,colors,params.Max_Value);
        scene.add(chartMesh);
    });
    
    // The key idea is the same as the row number
    maxValue.onChange(function(value) {  
        data = new Array();
        data = generateData(params.Rows, params.Columns,1,params.Max_Value);
        scene = new THREE.Scene(); 
        chartMesh = generateAreaChart(data,colors,params.Max_Value);
        scene.add(chartMesh);
    });
 
    // If the aren't changes the area chart is loaded with default data
    chartMesh = generateAreaChart(data,colors,params.Max_Value);
    scene.add(chartMesh);
}
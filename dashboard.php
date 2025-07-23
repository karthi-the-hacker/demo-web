<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.html');
    exit();
}
?>

<!DOCTYPE html>
<html>
    <body>
        <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cappriciosec University</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;900&display=swap');
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        overflow: hidden;
        background: #000;
        font-family: 'Orbitron', monospace;
        color: #00ff88;
    }

    #container {
        position: fixed;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg,
            #000506 0%,
            #001122 25%,
            #000814 50%,
            #001a0a 75%,
            #000208 100%
        );
    }

    .grid-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        opacity: 0.04;
        background-image: 
            linear-gradient(rgba(0, 255, 136, 0.1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 255, 136, 0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        animation: gridShift 20s linear infinite;
    }

    @keyframes gridShift {
        0% { transform: translate(0, 0); }
        100% { transform: translate(50px, 50px); }
    }

    .scan-line {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, 
            transparent 0%, 
            #00ff88 40%,
            #88ffaa 50%, 
            #00ff88 60%,
            transparent 100%);
        box-shadow: 
            0 0 30px #00ff88,
            0 0 60px rgba(0, 255, 136, 0.6),
            0 0 100px rgba(0, 255, 136, 0.3);
        animation: scanMove 3s ease-in-out infinite;
    }

    @keyframes scanMove {
        0%, 100% { top: 0%; opacity: 0; }
        10%, 90% { opacity: 1; }
        50% { top: 100%; }
    }

    .tech-pattern {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        opacity: 0.02;
        background-image: 
            radial-gradient(circle at 25% 25%, rgba(0, 255, 136, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(0, 136, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 50% 50%, rgba(255, 0, 136, 0.05) 0%, transparent 70%);
        animation: techPulse 8s ease-in-out infinite;
    }

    @keyframes techPulse {
        0%, 100% { opacity: 0.02; transform: scale(1); }
        50% { opacity: 0.06; transform: scale(1.1); }
    }

    .circuit-lines {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        opacity: 0.08;
        background-image: 
            linear-gradient(45deg, transparent 40%, rgba(0, 255, 136, 0.1) 41%, rgba(0, 255, 136, 0.1) 42%, transparent 43%),
            linear-gradient(-45deg, transparent 40%, rgba(0, 136, 255, 0.1) 41%, rgba(0, 136, 255, 0.1) 42%, transparent 43%);
        background-size: 200px 200px;
        animation: circuitFlow 15s linear infinite;
    }

    @keyframes circuitFlow {
        0% { background-position: 0px 0px, 0px 0px; }
        100% { background-position: 200px 200px, -200px 200px; }
    }

    #hud {
        position: fixed;
        top: 20px;
        left: 20px;
        font-size: 14px;
        color: #00ff88;
        text-transform: uppercase;
        letter-spacing: 2px;
        z-index: 100;
        background: rgba(0, 0, 0, 0.7);
        padding: 15px 20px;
        border: 1px solid rgba(0, 255, 136, 0.3);
        border-radius: 20px;
        font-weight: 500;
        backdrop-filter: blur(30px);
        box-shadow: 
            0 0 20px rgba(0, 255, 136, 0.3),
            inset 0 1px 0 rgba(0, 255, 136, 0.2),
            inset 0 0 20px rgba(0, 255, 136, 0.1);
        transition: all 0.3s ease;
    }

    #hud::before {
        content: '';
        position: absolute;
        top: -1px;
        left: -1px;
        right: -1px;
        bottom: -1px;
        background: linear-gradient(45deg, #00ff88, transparent, #00ff88);
        z-index: -1;
        border-radius: 20px;
        animation: borderGlow 3s ease-in-out infinite;
    }

    @keyframes borderGlow {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 0.8; }
    }

    .hud-line {
        margin: 3px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    .hud-line::after {
        content: '';
        position: absolute;
        right: -10px;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 4px;
        background: #00ff88;
        border-radius: 50%;
        animation: hudPulse 2s ease-in-out infinite;
    }

    @keyframes hudPulse {
        0%, 100% { opacity: 0.3; box-shadow: 0 0 5px #00ff88; }
        50% { opacity: 1; box-shadow: 0 0 15px #00ff88; }
    }

    .hud-value {
        color: #88ffaa;
        font-weight: 600;
        margin-left: 10px;
        text-shadow: 0 0 10px rgba(136, 255, 170, 0.5);
    }

    #status-indicator {
        width: 8px;
        height: 8px;
        background: #00ff88;
        border-radius: 50%;
        box-shadow: 0 0 10px #00ff88;
        animation: statusPulse 2s ease-in-out infinite;
    }

    @keyframes statusPulse {
        0%, 100% { opacity: 1; transform: scale(1); box-shadow: 0 0 10px #00ff88; }
        50% { opacity: 0.5; transform: scale(1.3); box-shadow: 0 0 20px #00ff88; }
    }

    #data-stream {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 48px;
        font-weight: 900;
        color: #00ff88;
        text-transform: uppercase;
        letter-spacing: 8px;
        opacity: 0 !important;
        transition: opacity 1s ease;
        z-index: 100;
        pointer-events: none;
        text-shadow: 
            0 0 20px #00ff88,
            0 0 40px #00ff88,
            0 0 60px #00ff88;
    }

    #control-panel {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        z-index: 100;
        width: 100%;
        padding: 0 20px;
    }

    .control-section {
        display: flex;
        align-items: center;
        gap: 20px;
        background: rgba(0, 0, 0, 0.7);
        padding: 15px 25px;
        border: 1px solid rgba(0, 255, 136, 0.3);
        border-radius: 20px;
        backdrop-filter: blur(30px);
        position: relative;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        overflow: hidden;
        box-shadow: inset 0 0 20px rgba(0, 255, 136, 0.1);
    }

    .control-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 1px;
        background: linear-gradient(90deg, transparent, #00ff88, transparent);
        animation: controlSweep 4s linear infinite;
    }

    .control-section::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: -100%;
        width: 100%;
        height: 1px;
        background: linear-gradient(90deg, transparent, #00ff88, transparent);
        animation: controlSweep 4s linear infinite reverse;
    }

    @keyframes controlSweep {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    .cyber-switch {
        position: relative;
        width: 60px;
        height: 30px;
        background: #001122;
        border: 1px solid #00ff88;
        cursor: pointer;
        transition: all 0.3s ease;
        overflow: hidden;
        border-radius: 15px;
    }

    .cyber-switch::before {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 26px;
        height: 26px;
        background: #00ff88;
        transition: all 0.3s ease;
        box-shadow: 0 0 10px #00ff88;
        border-radius: 50%;
    }

    .cyber-switch::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 136, 0.1) 50%, transparent 70%);
        animation: switchShimmer 3s ease-in-out infinite;
    }

    @keyframes switchShimmer {
        0%, 100% { transform: translateX(-100%); }
        50% { transform: translateX(100%); }
    }

    .cyber-switch.active::before {
        transform: translateX(30px);
        background: #88ffaa;
        box-shadow: 0 0 15px #88ffaa;
    }

    .cyber-switch.active {
        background: #002211;
        box-shadow: inset 0 0 10px #00ff88;
    }

    .switch-label {
        color: #00ff88;
        font-weight: 500;
        user-select: none;
        cursor: pointer;
        text-shadow: 0 0 5px rgba(0, 255, 136, 0.3);
        transition: all 0.3s ease;
    }

    .switch-label:hover {
        color: #88ffaa;
        text-shadow: 0 0 10px rgba(136, 255, 170, 0.5);
    }

    #execute-btn, #controls-toggle {
        background: rgba(0, 0, 0, 0.7);
        border: 2px solid rgba(0, 255, 136, 0.3);
        color: #00ff88;
        font-family: 'Orbitron', monospace;
        font-size: 14px;
        font-weight: 600;
        padding: 15px 30px;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 2px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(30px);
        border-radius: 30px;
        box-shadow: inset 0 0 20px rgba(0, 255, 136, 0.1);
    }

    #execute-btn::before, #controls-toggle::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(0, 255, 136, 0.2), transparent);
        transition: left 0.5s ease;
    }

    #execute-btn::after, #controls-toggle::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            linear-gradient(45deg, transparent 48%, rgba(0, 255, 136, 0.1) 49%, rgba(0, 255, 136, 0.1) 51%, transparent 52%),
            linear-gradient(-45deg, transparent 48%, rgba(0, 255, 136, 0.1) 49%, rgba(0, 255, 136, 0.1) 51%, transparent 52%);
        background-size: 20px 20px;
        animation: buttonPattern 2s linear infinite;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    @keyframes buttonPattern {
        0% { background-position: 0px 0px, 0px 0px; }
        100% { background-position: 20px 20px, -20px 20px; }
    }

    #execute-btn:hover, #controls-toggle:hover {
        background: rgba(0, 255, 136, 0.1);
        box-shadow: 
            0 0 20px rgba(0, 255, 136, 0.5),
            inset 0 0 20px rgba(0, 255, 136, 0.1);
        transform: scale(1.05);
    }

    #execute-btn:hover::before, #controls-toggle:hover::before {
        left: 100%;
    }

    #execute-btn:hover::after, #controls-toggle:hover::after {
        opacity: 1;
    }

    #execute-btn:active, #controls-toggle:active {
        transform: scale(0.98);
    }

    .cyber-icon {
        width: 16px;
        height: 16px;
        stroke: #00ff88;
        stroke-width: 2;
        fill: none;
        filter: drop-shadow(0 0 5px #00ff88);
        transition: all 0.3s ease;
    }

    #execute-btn:hover .cyber-icon, #controls-toggle:hover .cyber-icon {
        filter: drop-shadow(0 0 10px #00ff88);
        transform: scale(1.1);
    }
    
    #controls-toggle {
        display: none;
    }

    .performance-bars {
        position: fixed;
        top: 20px;
        right: 20px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        z-index: 100;
    }

    .perf-bar {
        width: 120px;
        height: 4px;
        background: rgba(0, 0, 0, 0.8);
        border: 1px solid #00ff88;
        position: relative;
        overflow: hidden;
    }

    .perf-bar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: linear-gradient(90deg, #ff0088, #00ff88, #0088ff);
        transition: width 0.3s ease;
        animation: perfPulse 2s ease-in-out infinite;
    }

    @keyframes perfPulse {
        0%, 100% { opacity: 0.8; }
        50% { opacity: 1; }
    }

    .perf-bar.cpu::before { width: 75%; }
    .perf-bar.gpu::before { width: 90%; }
    .perf-bar.memory::before { width: 60%; }

    .perf-label {
        font-size: 10px;
        color: #00ff88;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 2px;
    }

    @media (max-width: 850px) {
        #control-panel {
            flex-direction: column;
            gap: 15px;
            bottom: 20px;
        }
    }

    @media (max-width: 768px) {
        #controls-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            font-size: 12px;
        }
        
        .control-section {
            display: none;
        }
        
        #control-panel.expanded .control-section {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 15px 10px;
            align-items: center;
            padding: 15px 20px;
            font-size: 11px;
            width: auto;
            max-width: 300px;
        }

        #data-stream {
            font-size: 32px;
            letter-spacing: 4px;
        }

        #hud {
            font-size: 12px;
            padding: 12px 16px;
        }

        .performance-bars {
            top: 10px;
            right: 10px;
        }

        .perf-bar {
            width: 80px;
            height: 3px;
        }
    }

    @media (max-width: 480px) {
        #execute-btn {
            padding: 12px 24px;
            font-size: 12px;
        }

        #data-stream {
            font-size: 24px;
            letter-spacing: 2px;
        }

        .performance-bars {
            display: none;
        }
    }
</style>
<script type="importmap">
    {
        "imports": {
            "three": "https://cdn.jsdelivr.net/npm/three@0.162.0/build/three.module.js",
            "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.162.0/examples/jsm/"
        }
    }
</script>
<div id="container"></div>
<div class="grid-overlay"></div>
<div class="tech-pattern"></div>
<div class="circuit-lines"></div>
<div class="scan-line"></div>
<div id="hud">
    <div class="hud-line">
        <span>SYSTEM:</span>
        <span class="hud-value">ONLINE</span>
        <div id="status-indicator"></div>
    </div>
    <div class="hud-line">
        <span>FPS:</span>
        <span class="hud-value" id="fps-display">60</span>
    </div>
    <div class="hud-line">
        <span>NODES:</span>
        <span class="hud-value" id="node-display">24000</span>
    </div>
    <div class="hud-line">
        <span>MODE:</span>
        <span class="hud-value" id="mode-display">DATA STREAM</span>
    </div>
    <div class="hud-line">
        <span>TRAILS:</span>
        <span class="hud-value" id="trail-display">ACTIVE</span>
    </div>
</div>
<div class="performance-bars">
    <div class="perf-label">CPU LOAD</div>
    <div class="perf-bar cpu"></div>
    <div class="perf-label">GPU LOAD</div>
    <div class="perf-bar gpu"></div>
    <div class="perf-label">MEMORY</div>
    <div class="perf-bar memory"></div>
</div>
<div id="data-stream">DATA STREAM</div>
<div id="control-panel">
    <button id="controls-toggle">
        <svg class="cyber-icon" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <line x1="4" y1="21" x2="4" y2="14"></line>
            <line x1="4" y1="10" x2="4" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12" y2="3"></line>
            <line x1="20" y1="21" x2="20" y2="16"></line>
            <line x1="20" y1="12" x2="20" y2="3"></line>
            <line x1="1" y1="14" x2="7" y2="14"></line>
            <line x1="9" y1="8" x2="15" y2="8"></line>
            <line x1="17" y1="16" x2="23" y2="16"></line>
        </svg>
        CONTROLS
    </button>
    <div class="control-section">
        <div class="cyber-switch active" id="rotation-switch"></div>
        <span class="switch-label">AUTO_ROTATE</span>
        <div class="cyber-switch active" id="flow-switch"></div>
        <span class="switch-label">DATA_FLOW</span>
        <div class="cyber-switch active" id="trails-switch"></div>
        <span class="switch-label">TRAILS</span>
    </div>
    <button id="execute-btn">
        <svg class="cyber-icon" viewBox="0 0 24 24">
            <polygon points="5,3 19,12 5,21"/>
        </svg>
        EXECUTE_NEXT
    </button>
     <a href="logout.php"><button id="execute-btn"> Logout
        <svg class="cyber-icon" viewBox="0 0 24 24">
            <polygon points="5,3 19,12 5,21"/>
        </svg>
        
    </button></a>
</div>
<script type="module">
    import * as THREE from 'three';
    import { EffectComposer } from 'three/addons/postprocessing/EffectComposer.js';
    import { RenderPass } from 'three/addons/postprocessing/RenderPass.js';
    import { UnrealBloomPass } from 'three/addons/postprocessing/UnrealBloomPass.js';
    import { OutputPass } from 'three/addons/postprocessing/OutputPass.js';
    import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
    
    let scene, camera, renderer, dataNodes, trailSystem, backgroundNodes;
    let composer, controls;
    let time = 0;
    let currentVisualization = 0;
    let isTransforming = false;
    let transformProgress = 0;
    
    let frameCount = 0;
    let lastTime = performance.now();
    let fps = 60;
    
    let autoRotate = true;
    let dataFlow = true;
    let showTrails = true;
    
    const nodeCount = 24000;
    const trailCount = 8000;
    const transformSpeed = 0.02;
    const visualizationNames = [
        "DATA STREAM",
        "HOLOGRAPHIC NETWORK", 
        "PULSAR CORE"
    ];
    
    window.onload = initializeSystem;
    
    function generateDataStream(i, count) {
        const t = i / count;
        
        const channelCount = 10;
        const channelIndex = Math.floor(t * channelCount);
        const channelT = (t * channelCount) % 1;
        
        const channelAngle = (channelIndex / channelCount) * Math.PI * 2;
        const channelRadius = 20 + channelIndex * 5;
        
        const streamLength = 120;
        const packetPosition = channelT * streamLength - streamLength * 0.5;
        
        const helixRadius = 2.5 + Math.sin(channelT * Math.PI * 4) * 1.5;
        const helixAngle = packetPosition * 0.15 + channelAngle;

        const x = Math.cos(helixAngle) * (channelRadius + helixRadius);
        const y = packetPosition;
        const z = Math.sin(helixAngle) * (channelRadius + helixRadius);
        
        return new THREE.Vector3(x, y, z);
    }
    
    function generateHolographicNetwork(i, count) {
        const layerCount = 8;
        const layerIndex = Math.floor(i / (count / layerCount));
        const nodeInLayer = i % Math.floor(count / layerCount);
        const nodeInLayerT = nodeInLayer / Math.floor(count / layerCount);

        const layerHeight = (layerIndex - layerCount / 2) * 15;
        const layerRadius = 30 + Math.sin(layerIndex * 0.8) * 20;
        const angle = nodeInLayerT * Math.PI * 2;
        
        const yOffset = Math.sin(angle * (4 + layerIndex % 3)) * 4; 

        const x = Math.cos(angle) * layerRadius;
        const y = layerHeight + yOffset;
        const z = Math.sin(angle) * layerRadius;

        return new THREE.Vector3(x, y, z);
    }
    
    function generatePulsarCore(i, count) {
        const coreRatio = 0.3;
        const coreCount = Math.floor(count * coreRatio);

        if (i < coreCount) {
            const t = i / coreCount;
            const phi = Math.acos(1 - 2 * t);
            const theta = Math.PI * (1 + Math.sqrt(5)) * i;
            
            const radius = 20 * Math.pow(Math.random(), 2);

            const x = radius * Math.sin(phi) * Math.cos(theta);
            const y = radius * Math.sin(phi) * Math.sin(theta);
            const z = radius * Math.cos(phi);
            return new THREE.Vector3(x, y, z);

        } else {
            const ringParticles = count - coreCount;
            const ringIndex = i - coreCount;
            
            const numRings = 6;
            const ringNum = Math.floor(ringIndex / (ringParticles / numRings));
            const nodeInRing = ringIndex % Math.floor(ringParticles / numRings);
            const nodeInRingT = nodeInRing / Math.floor(ringParticles / numRings);

            const angle = nodeInRingT * Math.PI * 2;
            const baseRadius = 30 + ringNum * 8;
            const ringRadius = baseRadius;

            const tiltAngle = (ringNum % 2 === 0 ? 1 : -1) * (Math.PI / 8 + ringNum * Math.PI / 20);
            const axisAngle = ringNum * Math.PI / 3;
            const axis = new THREE.Vector3(Math.sin(axisAngle), Math.cos(axisAngle), 0).normalize();
            const rotationMatrix = new THREE.Matrix4().makeRotationAxis(axis, tiltAngle);

            const pos = new THREE.Vector3(
                Math.cos(angle) * ringRadius,
                Math.sin(angle) * ringRadius,
                0
            );

            pos.applyMatrix4(rotationMatrix);

            return pos;
        }
    }
    
    const visualizations = [
        generateDataStream,
        generateHolographicNetwork,
        generatePulsarCore
    ];
    
    const colorSchemes = [
        [
            new THREE.Color(0x00ff88),
            new THREE.Color(0x00dd77),
            new THREE.Color(0x00bb66),
            new THREE.Color(0x44ffaa),
            new THREE.Color(0x66ffcc),
            new THREE.Color(0x88ffdd),
            new THREE.Color(0x22ff99),
            new THREE.Color(0x00ffaa)
        ],
        [
            new THREE.Color(0x0088ff),
            new THREE.Color(0x0066dd),
            new THREE.Color(0x4499ff),
            new THREE.Color(0x6644ff),
            new THREE.Color(0x8866ff),
            new THREE.Color(0xaa88ff),
            new THREE.Color(0x2266ff),
            new THREE.Color(0x4488dd)
        ],
        [
            new THREE.Color(0xffffff),
            new THREE.Color(0xffff88),
            new THREE.Color(0xffaa33),
            new THREE.Color(0x00aaff),
            new THREE.Color(0x44ccff),
            new THREE.Color(0x88ddff),
            new THREE.Color(0x0088cc),
            new THREE.Color(0xff6600)
        ]
    ];
    
    function createTrailSystem() {
        const trailGeometry = new THREE.BufferGeometry();
        const trailPositions = new Float32Array(trailCount * 3);
        const trailColors = new Float32Array(trailCount * 3);
        const trailSizes = new Float32Array(trailCount);
        const trailOpacities = new Float32Array(trailCount);
        
        for (let i = 0; i < trailCount; i++) {
            trailPositions[i * 3] = (Math.random() - 0.5) * 100;
            trailPositions[i * 3 + 1] = (Math.random() - 0.5) * 100;
            trailPositions[i * 3 + 2] = (Math.random() - 0.5) * 100;
            
            const colorScheme = colorSchemes[currentVisualization];
            const color = colorScheme[Math.floor(Math.random() * colorScheme.length)];
            trailColors[i * 3] = color.r;
            trailColors[i * 3 + 1] = color.g;
            trailColors[i * 3 + 2] = color.b;
            
            trailSizes[i] = Math.random() * 1.5 + 0.5;
            trailOpacities[i] = Math.random() * 0.5 + 0.2;
        }
        
        trailGeometry.setAttribute('position', new THREE.BufferAttribute(trailPositions, 3));
        trailGeometry.setAttribute('color', new THREE.BufferAttribute(trailColors, 3));
        trailGeometry.setAttribute('size', new THREE.BufferAttribute(trailSizes, 1));
        trailGeometry.setAttribute('opacity', new THREE.BufferAttribute(trailOpacities, 1));
        
        const trailTexture = createTrailTexture();
        const trailMaterial = new THREE.PointsMaterial({
            size: 2.0,
            map: trailTexture,
            vertexColors: true,
            transparent: true,
            blending: THREE.AdditiveBlending,
            depthWrite: false,
            opacity: 0.6
        });
        
        trailSystem = new THREE.Points(trailGeometry, trailMaterial);
        scene.add(trailSystem);
    }
    
    function createTrailTexture() {
        const canvas = document.createElement('canvas');
        canvas.width = 32;
        canvas.height = 32;
        const context = canvas.getContext('2d');
        
        const gradient = context.createRadialGradient(16, 16, 0, 16, 16, 16);
        gradient.addColorStop(0, 'rgba(255, 255, 255, 0.8)');
        gradient.addColorStop(0.3, 'rgba(255, 255, 255, 0.4)');
        gradient.addColorStop(0.7, 'rgba(255, 255, 255, 0.1)');
        gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');
        
        context.fillStyle = gradient;
        context.fillRect(0, 0, 32, 32);
        
        const texture = new THREE.CanvasTexture(canvas);
        texture.needsUpdate = true;
        return texture;
    }
    
    function createBackgroundParticles() {
        const bgGeometry = new THREE.BufferGeometry();
        const bgCount = 2000;
        const bgPositions = new Float32Array(bgCount * 3);
        const bgColors = new Float32Array(bgCount * 3);
        const bgSizes = new Float32Array(bgCount);
        
        for (let i = 0; i < bgCount; i++) {
            const radius = 200 + Math.random() * 300;
            const phi = Math.random() * Math.PI * 2;
            const theta = Math.random() * Math.PI;
            
            bgPositions[i * 3] = radius * Math.sin(theta) * Math.cos(phi);
            bgPositions[i * 3 + 1] = radius * Math.sin(theta) * Math.sin(phi);
            bgPositions[i * 3 + 2] = radius * Math.cos(theta);
            
            const intensity = Math.random() * 0.3 + 0.1;
            bgColors[i * 3] = intensity * 0.2;
            bgColors[i * 3 + 1] = intensity * 0.5;
            bgColors[i * 3 + 2] = intensity * 0.3;
            
            bgSizes[i] = Math.random() * 2 + 0.5;
        }
        
        bgGeometry.setAttribute('position', new THREE.BufferAttribute(bgPositions, 3));
        bgGeometry.setAttribute('color', new THREE.BufferAttribute(bgColors, 3));
        bgGeometry.setAttribute('size', new THREE.BufferAttribute(bgSizes, 1));
        
        const bgMaterial = new THREE.PointsMaterial({
            size: 1.0,
            vertexColors: true,
            transparent: true,
            opacity: 0.4,
            blending: THREE.AdditiveBlending,
            depthWrite: false
        });
        
        backgroundNodes = new THREE.Points(bgGeometry, bgMaterial);
        scene.add(backgroundNodes);
    }
    
    function initializeSystem() {
        scene = new THREE.Scene();
        scene.fog = new THREE.FogExp2(0x000814, 0.0006);
        
        camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 2000);
        camera.position.set(0, 0, 120);
        
        renderer = new THREE.WebGLRenderer({ 
            antialias: true, 
            alpha: true,
            powerPreference: "high-performance" 
        });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        renderer.toneMapping = THREE.ACESFilmicToneMapping;
        renderer.toneMappingExposure = 1.1;
        document.getElementById('container').appendChild(renderer.domElement);
        
        setupCameraControls();
        setupPostProcessing();
        createDataVisualization();
        createTrailSystem();
        createBackgroundParticles();
        setupEventHandlers();
        
        displayVisualizationName(visualizationNames[currentVisualization]);
        executeMainLoop();
    }
    
    function setupCameraControls() {
        controls = new OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.08;
        controls.rotateSpeed = 0.5;
        controls.zoomSpeed = 0.8;
        controls.minDistance = 40;
        controls.maxDistance = 300;
        controls.enablePan = false;
        controls.autoRotate = true;
        controls.autoRotateSpeed = 0.3; 
    }
    
    function setupPostProcessing() {
        composer = new EffectComposer(renderer);
        composer.addPass(new RenderPass(scene, camera));
        
        const bloomPass = new UnrealBloomPass(
            new THREE.Vector2(window.innerWidth, window.innerHeight),
            0.4,
            0.5,
            0.85
        );
        composer.addPass(bloomPass);
        
        composer.addPass(new OutputPass());
    }
    
    function createDataVisualization() {
        const geometry = new THREE.BufferGeometry();
        const positions = new Float32Array(nodeCount * 3);
        const colors = new Float32Array(nodeCount * 3);
        const sizes = new Float32Array(nodeCount);
        
        const initialVisualization = visualizations[currentVisualization];
        
        for (let i = 0; i < nodeCount; i++) {
            const pos = initialVisualization(i, nodeCount);
            positions[i * 3] = pos.x;
            positions[i * 3 + 1] = pos.y;
            positions[i * 3 + 2] = pos.z;
            
            assignParticleProperties(i, colors, sizes, currentVisualization);
        }
        
        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));
        geometry.setAttribute('size', new THREE.BufferAttribute(sizes, 1));
        
        geometry.userData.currentColors = new Float32Array(colors);
        
        const texture = createEnhancedParticleTexture();
        const material = new THREE.PointsMaterial({
            size: 3.5,
            map: texture,
            vertexColors: true,
            transparent: true,
            blending: THREE.AdditiveBlending,
            depthWrite: false
        });
        
        dataNodes = new THREE.Points(geometry, material);
        scene.add(dataNodes);
    }

    function assignParticleProperties(i, colors, sizes, vizIndex) {
        const colorScheme = colorSchemes[vizIndex];
        let color;
        let brightness = 1.0;

        if (vizIndex === 0) {
            const channelIndex = Math.floor((i / nodeCount) * 10);
            color = colorScheme[channelIndex % colorScheme.length];
            brightness = 0.7 + Math.random() * 0.6;
            sizes[i] = 0.8 + Math.random() * 2.0;
        } else if (vizIndex === 1) {
            const layerIndex = Math.floor(i / (nodeCount / 8));
            color = colorScheme[layerIndex % colorScheme.length];
            brightness = 0.8 + Math.random() * 0.5;
            sizes[i] = 0.8 + Math.random() * 2.0;
        } else {
            const coreRatio = 0.3;
            const coreCount = Math.floor(nodeCount * coreRatio);
            if (i < coreCount) {
                color = colorScheme[i % 3];
                brightness = 1.0 + Math.random() * 0.5;
                sizes[i] = 1.5 + Math.random() * 2.0;
            } else {
                color = colorScheme[3 + (i % (colorScheme.length - 3))];
                brightness = 0.7 + Math.random() * 0.5;
                sizes[i] = 0.8 + Math.random() * 1.5;
            }
        }
        
        colors[i * 3] = color.r * brightness;
        colors[i * 3 + 1] = color.g * brightness;
        colors[i * 3 + 2] = color.b * brightness;
    }
    
    function createEnhancedParticleTexture() {
        const canvas = document.createElement('canvas');
        canvas.width = 128;
        canvas.height = 128;
        const context = canvas.getContext('2d');
        
        const centerX = 64, centerY = 64;
        
        const outerGradient = context.createRadialGradient(centerX, centerY, 0, centerX, centerY, 64);
        outerGradient.addColorStop(0, 'rgba(255, 255, 255, 1.0)');
        outerGradient.addColorStop(0.2, 'rgba(255, 255, 255, 0.6)');
        outerGradient.addColorStop(0.5, 'rgba(128, 255, 200, 0.3)');
        outerGradient.addColorStop(1, 'rgba(0, 0, 0, 0)');
        
        context.fillStyle = outerGradient;
        context.fillRect(0, 0, 128, 128);
        
        const coreGradient = context.createRadialGradient(centerX, centerY, 0, centerX, centerY, 12);
        coreGradient.addColorStop(0, 'rgba(255, 255, 255, 1.0)');
        coreGradient.addColorStop(1, 'rgba(128, 255, 200, 0.2)');
        
        context.fillStyle = coreGradient;
        context.beginPath();
        context.arc(centerX, centerY, 12, 0, Math.PI * 2);
        context.fill();
        
        const texture = new THREE.CanvasTexture(canvas);
        texture.needsUpdate = true;
        return texture;
    }
    
    function setupEventHandlers() {
        window.addEventListener('resize', onSystemResize);
        
        const rotationSwitch = document.getElementById('rotation-switch');
        if (rotationSwitch) {
            rotationSwitch.addEventListener('click', () => {
                autoRotate = !autoRotate;
                controls.autoRotate = autoRotate;
                rotationSwitch.classList.toggle('active', autoRotate);
            });
        }
        
        const flowSwitch = document.getElementById('flow-switch');
        if (flowSwitch) {
            flowSwitch.addEventListener('click', () => {
                dataFlow = !dataFlow;
                flowSwitch.classList.toggle('active', dataFlow);
            });
        }
        
        const trailsSwitch = document.getElementById('trails-switch');
        if (trailsSwitch) {
            trailsSwitch.addEventListener('click', () => {
                showTrails = !showTrails;
                trailsSwitch.classList.toggle('active', showTrails);
                if (trailSystem) {
                    trailSystem.visible = showTrails;
                    document.getElementById('trail-display').textContent = showTrails ? 'ACTIVE' : 'INACTIVE';
                }
            });
        }
        
        const executeBtn = document.getElementById('execute-btn');
        if (executeBtn) {
            executeBtn.addEventListener('click', executeTransformation);
            executeBtn.addEventListener('touchend', (e) => {
                e.preventDefault();
                executeTransformation();
            });
        }

        const controlsToggle = document.getElementById('controls-toggle');
        const controlPanel = document.getElementById('control-panel');
        if (controlsToggle && controlPanel) {
            controlsToggle.addEventListener('click', () => {
                controlPanel.classList.toggle('expanded');
            });
        }
    }
    
    function executeTransformation() {
        if (isTransforming) return;
        
        const nextVisualization = (currentVisualization + 1) % visualizations.length;
        transformToVisualization(nextVisualization);
        displayVisualizationName(visualizationNames[nextVisualization]);
    }
    
    function transformToVisualization(newVisualization) {
        isTransforming = true;
        transformProgress = 0;
        
        const positions = dataNodes.geometry.attributes.position.array;
        const colors = dataNodes.geometry.attributes.color.array;
        const sizes = dataNodes.geometry.attributes.size.array;
        
        const currentPositions = new Float32Array(positions);
        const currentColors = new Float32Array(dataNodes.geometry.userData.currentColors);
        const currentSizes = new Float32Array(sizes);
        
        const visualizationFunction = visualizations[newVisualization];
        const newPositions = new Float32Array(positions.length);
        const newColors = new Float32Array(colors.length);
        const newSizes = new Float32Array(sizes.length);
        
        for (let i = 0; i < nodeCount; i++) {
            const pos = visualizationFunction(i, nodeCount);
            newPositions[i * 3] = pos.x;
            newPositions[i * 3 + 1] = pos.y;
            newPositions[i * 3 + 2] = pos.z;
            assignParticleProperties(i, newColors, newSizes, newVisualization);
        }
        
        dataNodes.userData.fromPositions = currentPositions;
        dataNodes.userData.toPositions = newPositions;
        dataNodes.userData.fromColors = currentColors;
        dataNodes.userData.toColors = newColors;
        dataNodes.userData.fromSizes = currentSizes;
        dataNodes.userData.toSizes = newSizes;
        dataNodes.userData.targetVisualization = newVisualization;
        
        if (trailSystem) {
            const trailColors = trailSystem.geometry.attributes.color.array;
            const newColorScheme = colorSchemes[newVisualization];
            for (let i = 0; i < trailCount; i++) {
                const color = newColorScheme[Math.floor(Math.random() * newColorScheme.length)];
                trailColors[i * 3] = color.r;
                trailColors[i * 3 + 1] = color.g;
                trailColors[i * 3 + 2] = color.b;
            }
            trailSystem.geometry.attributes.color.needsUpdate = true;
        }
    }
    
    function displayVisualizationName(name) {
        const modeElement = document.getElementById('mode-display');
        modeElement.textContent = name;
    }
    
    function updateSystemStatus() {
        frameCount++;
        const currentTime = performance.now();
        
        if (currentTime - lastTime >= 1000) {
            fps = Math.round((frameCount * 1000) / (currentTime - lastTime));
            document.getElementById('fps-display').textContent = fps;
            document.getElementById('node-display').textContent = nodeCount.toLocaleString();
            
            frameCount = 0;
            lastTime = currentTime;
        }
    }
    
    function animateTrailSystem() {
        if (!trailSystem || !showTrails) return;
        
        const positions = trailSystem.geometry.attributes.position.array;
        const opacities = trailSystem.geometry.attributes.opacity.array;
        
        for (let i = 0; i < trailCount; i++) {
            const ix = i * 3, iy = ix + 1, iz = ix + 2;
            
            switch(currentVisualization) {
                case 0:
                    positions[iy] += 0.3;
                    if (positions[iy] > 60) positions[iy] = -60;
                    positions[ix] += Math.sin(time * 2 + i * 0.1) * 0.1;
                    positions[iz] += Math.cos(time * 1.8 + i * 0.1) * 0.1;
                    break;
                case 1:
                    const distance = Math.sqrt(positions[ix] * positions[ix] + positions[iz] * positions[iz]);
                    if (distance > 0.1) {
                        const expansion = 1 + Math.sin(time * 3 + i * 0.05) * 0.005;
                        positions[ix] *= expansion;
                        positions[iz] *= expansion;
                    }
                    positions[iy] += Math.sin(time * 2.5 + i * 0.03) * 0.2;
                    break;
                case 2:
                    const orbitSpeed = 0.01 + (i % 5) * 0.005;
                    const x = positions[ix];
                    const z = positions[iz];
                    positions[ix] = x * Math.cos(orbitSpeed) - z * Math.sin(orbitSpeed);
                    positions[iz] = x * Math.sin(orbitSpeed) + z * Math.cos(orbitSpeed);
                    break;
            }
            
            opacities[i] = 0.3 + Math.sin(time * 3 + i * 0.1) * 0.3;
        }
        
        trailSystem.geometry.attributes.position.needsUpdate = true;
        trailSystem.geometry.attributes.opacity.needsUpdate = true;
    }
    
    function animateDataFlow() {
        if (!dataNodes || isTransforming || !dataFlow) return;
        
        const positions = dataNodes.geometry.attributes.position.array;
        
        switch(currentVisualization) {
            case 0:
                for (let i = 0; i < nodeCount; i++) {
                    const iy = i * 3 + 1;
                    positions[iy] += 0.4;
                    if (positions[iy] > 60) positions[iy] -= 120;
                }
                dataNodes.geometry.attributes.position.needsUpdate = true;
                break;
            case 1:
                const layerCount = 8;
                for (let i = 0; i < nodeCount; i++) {
                    const layerIndex = Math.floor(i / (nodeCount / layerCount));
                    const ix = i * 3, iz = i * 3 + 2;
                    const x = positions[ix];
                    const z = positions[iz];
                    
                    const rotationSpeed = 0.005 + (layerIndex % 3) * 0.003;
                    positions[ix] = x * Math.cos(rotationSpeed) - z * Math.sin(rotationSpeed);
                    positions[iz] = x * Math.sin(rotationSpeed) + z * Math.cos(rotationSpeed);
                }
                dataNodes.geometry.attributes.position.needsUpdate = true;
                break;
            case 2:
                const coreRatio = 0.3;
                const coreCount = Math.floor(nodeCount * coreRatio);

                for (let i = 0; i < nodeCount; i++) {
                    const ix = i * 3, iy = i * 3 + 1, iz = i * 3 + 2;
                    let x = positions[ix], y = positions[iy], z = positions[iz];
                    let rotationSpeed;

                    if (i < coreCount) {
                        rotationSpeed = 0.001;
                    } else {
                        const ringParticles = nodeCount - coreCount;
                        const ringIndex = i - coreCount;
                        const numRings = 6;
                        const ringNum = Math.floor(ringIndex / (ringParticles / numRings));
                        rotationSpeed = 0.002 + ringNum * 0.0015;
                    }

                    positions[ix] = x * Math.cos(rotationSpeed) - z * Math.sin(rotationSpeed);
                    positions[iz] = x * Math.sin(rotationSpeed) + z * Math.cos(rotationSpeed);
                }
                dataNodes.geometry.attributes.position.needsUpdate = true;
                break;
        }
    }
    
    function onSystemResize() {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
        composer.setSize(window.innerWidth, window.innerHeight);
    }
    
    function executeMainLoop() {
        requestAnimationFrame(executeMainLoop);
        time += 0.01;
        
        updateSystemStatus();
        controls.update();
        
        if (backgroundNodes) {
            backgroundNodes.rotation.y += 0.0003;
            backgroundNodes.rotation.x += 0.0001;
        }
        
        if (isTransforming) {
            transformProgress += transformSpeed;
            
            if (transformProgress >= 1.0) {
                const positions = dataNodes.geometry.attributes.position.array;
                const colors = dataNodes.geometry.attributes.color.array;
                const sizes = dataNodes.geometry.attributes.size.array;
                
                positions.set(dataNodes.userData.toPositions);
                colors.set(dataNodes.userData.toColors);
                sizes.set(dataNodes.userData.toSizes);
                
                dataNodes.geometry.attributes.position.needsUpdate = true;
                dataNodes.geometry.attributes.color.needsUpdate = true;
                dataNodes.geometry.attributes.size.needsUpdate = true;
                
                dataNodes.geometry.userData.currentColors = new Float32Array(dataNodes.userData.toColors);
                currentVisualization = dataNodes.userData.targetVisualization;
                isTransforming = false;
                transformProgress = 0;
            } else {
                const positions = dataNodes.geometry.attributes.position.array;
                const colors = dataNodes.geometry.attributes.color.array;
                const sizes = dataNodes.geometry.attributes.size.array;
                
                const t = transformProgress;
                const ease = t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
                
                for (let i = 0; i < positions.length; i++) {
                    positions[i] = dataNodes.userData.fromPositions[i] * (1 - ease) + 
                                   dataNodes.userData.toPositions[i] * ease;
                    colors[i] = dataNodes.userData.fromColors[i] * (1 - ease) + 
                                dataNodes.userData.toColors[i] * ease;
                }
                
                for (let i = 0; i < sizes.length; i++) {
                    sizes[i] = dataNodes.userData.fromSizes[i] * (1 - ease) + 
                               dataNodes.userData.toSizes[i] * ease;
                }
                
                dataNodes.geometry.attributes.position.needsUpdate = true;
                dataNodes.geometry.attributes.color.needsUpdate = true;
                dataNodes.geometry.attributes.size.needsUpdate = true;
            }
        } else {
            animateDataFlow();
        }
        
        animateTrailSystem();
        composer.render();
    }
</script>

    </body>
</html>

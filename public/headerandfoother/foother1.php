<style>
    #piePagina {
    background: linear-gradient(45deg, #135787, #1982c4);
    color: white;
    padding: 40px 0;
    text-align: center;
    font-family: saira;
}

/* Estilo para los títulos del footer */
#piePagina h5 {
    font-size: 1.3rem;
    margin-bottom: 15px;
    text-transform: uppercase;
    font-weight: bold;
}

/* Espaciado entre los elementos de la lista */
#piePagina ul {
    padding: 0;
    list-style: none;
}

#piePagina ul li {
    margin: 8px 0;
}

/* Enlaces del footer */
#piePagina a {
    color: white;
    text-decoration: none;
    font-size: 1.1rem;
    transition: color 0.3s ease-in-out;
}

#piePagina a:hover {
    color: #ffcc00; /* Amarillo suave */
    text-decoration: underline;
}

/* Íconos más grandes y con efecto */
#piePagina i {
    font-size: 1.3rem;
    margin-right: 8px;
    transition: transform 0.3s ease-in-out;
}

#piePagina a:hover i {
    transform: scale(1.2);
}

/* Separación entre las secciones */
#piePagina .col-md-4 {
    margin-bottom: 20px;
}

/* Línea superior para separar derechos de autor */
#derechos {
    background-color: rgba(0, 0, 0, 0.2);
    padding: 10px;
    font-size: 0.9rem;
}

@media (min-width: 768px) {
    #piePagina .col-md-4 {
        margin-bottom: 0;
    }
}
</style>

<footer>
    <div class="text-white mt-5" id="piePagina">
        <div class="container py-5">
        <div class="row">
        
            <div class="col-lg-4 lg-4">
            <h5>Enlaces</h5>
            <ul class="list-unstyled">
                <li><a href="javascript:void(0);" onclick="window.location.replace('home.php');" class="text-white text-decoration-none">Inicio</a></li>
                <li><a href="javascript:void(0);" onclick="window.location.replace('creacion.html');" class="text-white text-decoration-none">Creación</a></li>
                <li><a href="javascript:void(0);" onclick="window.location.replace('../cliente/visualizacion.html');" class="text-white text-decoration-none">Visualización</a></li>
                <li><a href="soporte.html" class="text-white text-decoration-none">Soporte</a></li>
            </ul>
            </div>      
        
            <div class="col-lg-4 lg-4">
            <h5> Información de Contacto</h5>
            <ul class="list-unstyled">
                <li><i class="bi bi-geo-alt"></i> Dirección: Calle 90 #12-35, Bogotá, Colombia</li>
                <li><i class="bi bi-telephone"></i> Teléfono: +57 312 857 7856</li>
                <li><i class="bi bi-envelope"></i> Correo: softgen14@gmail.com</li>
            </ul>
            </div>     
            
            <div class="col-lg-4 lg-4">
            <h5>Síguenos</h5>
            <ul class="list-unstyled">
                <li><a href="https://www.facebook.com/profile.php?id=61574843906898" class="text-white text-decoration-none"><i class="bi bi-facebook"></i>Facebook</a></li>
                <li><a href="https://x.com/Softgen291521" class="text-white text-decoration-none"><i class="bi bi-twitter-x"></i>Twitter</a></li>
                <li><a href="https://www.instagram.com/softg_en?igsh=amp3dmF3dzdqbWtq" class="text-white text-decoration-none"><i class="bi bi-instagram"></i>Instagram</a></li>
            </ul>
            </div>
        </div>
        </div>     
    
        <div class="text-center py-3" id="derechos">
        <p class="mb-0">&copy; 2025 SoftGen. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

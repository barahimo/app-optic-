@extends('layout.dashboard')

@section('contenu')

<style>
    .main-content {
    position: relative;
    margin-left:240px;
}

/* main{ 
    margin-top: 60px ;
    background: #f1f5f9;
    min-height: 98vh;
    padding: 1rem 3rem;
} */

.dash-title{
    color: var(--color-dark) ;
    margin-bottom: 1rem;
    padding: 1rem 3rem;
    
}
.dash-cards{
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-column-gap: 3rem ;
    padding: 0rem 3rem;
}

.card-single{
    background: #fff;
    border-radius: 7px;
    box-shadow: 2px 2px 2px rgb(0,0,0,0.3);
      
}
.card-body {
    padding:1.3rem 1rem;
    display: flex;
    align-items: center;
}
.card-body span {
    font-size: 1.5rem;
    color: #777;
    padding-right: 1.4rem;
}
.card-body h5{
    color: var(--text-grey);
    font-size: 1rem;
}
.card-body h4{

   color: var(--color-dark);
   font-size: 1.1rem; 
   margin-top: .2rem;

}
.card-footer {
    padding: 1rem 4rem ;
    background: #f9fafc ;
}
.card-footer a {
    color: var(--main-color); 
   }



   .recent{
       margin-top: 1rem;
       margin-left: 3rem;
   }
   .activity-grid{
     display: grid ;
     grid-template-columns:75% 25% ;
     grid-column-gap: 1.5rem;
   }
   .activity-card,
   .summary-card,
   .bday-card {
       background : #fff;
       border-radius: 7px;
   }
   .activity-card h3{
       color:var(--text-grey);
       margin:1rem;
   }
   .activity-card table{
       width: 100%;
       border-collapse:collapse
   }
   .activity-card thead{
       background-color:#efefef;
       text-align:left;
   }
   th, td {
       font-size:  18px;
       padding : 1rem 1rem;
       color: var(--color-dark);
   }
   td {
       font-size : 14px;
   }
   tbody tr:nth-child(even){
       background: #f9fafc
   }
   .summary-card
    {
       margin-bottom:1.5rem;
       margin-right : 70px;
       padding-top: .5rem;
       padding-bottom: .5rem;
       
   }
   .summary-single{
       padding: .5rem 1rem;
       display: flex;
       align-items: center;
       
   }
   .summary-single span {
       font-size:1.5rem;
       color: #777;
       padding-right: 1rem;
   }
   .summary-single h5 {
       color:var(--main-color);
       font-size:15px;
       margin-bottom:.2rem !important;
   }
   .summaru-single small {
       font-weight: 700;
       color: var(--text-grey);
   }
   .bday-card{
       padding: 1rem;
       display: flex;
       align-items: center;
   }


</style>

<h2 class="dash-title">Bienvenue !</h2>

<div class="dash-cards">
    <div class="card-single">
        <div class="card-body">
            <span class="ti-briefcase"></span>
            <div>
                <h5>Clients</h5>
                <h4>nbres des clients : 3</h4>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('client.index')}}"> Voir tout</a>
        </div>
    </div>

    <div class="card-single">
        <div class="card-body">
            <span class="ti-reload"></span>
            <div>
                <h5>Produits</h5>
                <h4>nombres des produits :13</h4>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('produit.index')}}"> Voir tout</a>
        </div>
    </div>

    <div class="card-single">
        <div class="card-body">
            <span class="ti-check-box"></span>
            <div>
                <h5> Commandes</h5>
                <h4> nombre de commandes : 2</h4>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('commande.affiche')}}">Voir tout</a>
        </div>
    </div>
</div>
<section class="recent">
 <div class="activity-grid">
    <div class="activity-card">
        <h3>activités récentes</h3>
        <table >
            <thead>
                <tr>
                    <th>Clients</th>
                    <th>commandes</th>
                    <th>Produits</th>
                    <th>règlements</th>
                    <th>factures</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rachida oubouali</td>
                    <td><a href="">voir</a></td>
                    <td><a href="">voir</a></td>
                    <td><a href="">voir</a></td>
                    <td><a href="">voir</a></td>
                </tr>
                <tr>
                    <td>sanae oubouali</td>
                    <td><a href="">voir</a></td>
                    <td><a href="">voir</a></td>
                    <td><a href="">voir</a></td>
                    <td><a href="">voir</a></td>
                </tr>
                <tr>
                    <td>adam oubouali</td>
                    <td><a href="">voir</a></td>
                    <td><a href="">voir</a></td>
                    <td><a href="">voir</a></td>
                    <td><a href="">voir</a></td>
                </tr>
                
                
            </tbody>
        </table>
    </div>
        <div class="summary">
            <div class="summary-card">
                <div class="summary-single">
                    <span class="ti-id-badge"></span>
                    <div>
                        <h5>61</h5>
                        <small>demandes</small>
                    </div>
                </div>
                <div class="summary-single">
                    <span class="ti-face-smile"></span>
                    <div>
                        <h5>16</h5>
                        <small>notes</small>
                    </div>
                </div>
                <div class="summary-single">
                    <span class="ti-calendar"></span>
                    <div>
                        <h5>19</h5>
                        <small>statistique</small>
                    </div>
                </div>
               
            </div>


           


            <!-- <div class="bday-card">

                <div class="bday-img"></div>
                <div class="bday-info">
                    <h5>dwayne f today</h5>
                    <small>birthay today</small>
                    <div>
                        <button>
                            <span class="ti-gift"></span>
                            wish him
                        </button>
                    </div>
                </div>
             </div> 
             -->
        </div>
    
 </div>   
</section>




@endsection
<html>
<head>
<title>Magasins</title>
<style type="text/css">
    #page-wrap {
        width: 700px;
        margin: 0 auto;
    }
    .center-justified {
        text-align: justify;
        margin: 0 auto;
        width: 30em;
    }
    table.outline-table {
        border: 1px solid;
        border-spacing: 0;
    }
    tr.border-bottom td, td.border-bottom {
        border-bottom: 1px solid;
    }
    tr.border-top td, td.border-top {
        border-top: 1px solid;
    }
    tr.border-right td, td.border-right {
        border: 1px solid;
    }
    tr.border-right td:last-child {
        border-right: 0px;
    }
    tr.center td, td.center {
        text-align: center;
        vertical-align: text-top;
    }
    td.pad-left {
        padding-left: 5px;
    }
    tr.right-center td, td.right-center {
        text-align: right;
        padding-right: 50px;
    }
    tr.right td, td.right {
        text-align: right;
    }
    .grey {
        background:grey;
    }
</style>
</head>
<body>
  <div id="page-wrap">
      <table width="100%">
          <thead>
              <tr>
                  <th width="30%">
                      <img src="images/golfmaroc.png">
                  </th>
                  <th width="70%" colspan="4">
                      <center>Magasin N° 3 Bloc A1 Residence Tifaouine </center>
                        <center>Av. Moukaouama Agadir </center>
                        <center>Tel : 0528 844 727
                        Fax : 0528 844 710  </center>

                  </th>
                </tr>
                  <tr>
                  <th width="70%" colspan="3">
                      <h1><center>Liste des Magasins</center></h1><br>

                  </th>
              </tr>
          </thead>
      </table>

      <p>&nbsp;</p>


        <table width="100%" class="outline-table">
            <tbody>
                <tr class="border-bottom border-right grey">
                    <td colspan="9"><center><strong>Liste des Magasins</strong></td>
                </tr>
                <tr class="border-bottom border-right center">
                    <td width="5%"><strong> # </strong></td>
                    <td><strong>Nom Magasin</strong></td>
                      <td><strong>Ville</strong></td>
                        <td><strong>Nom de l'Agent</strong></td>
                    <td ><strong>Telephone</strong></td>
                    <td ><strong>Email</strong></td>
                    <td ><strong>Adresse</strong></td>
                    <td ><strong>Description</strong></td>
                    <td width="30%" ><strong>Date de création</strong></td>
                </tr>
                @foreach($data as $item)
                <tr class="border-right">
                  <td class="center">{{ $loop->index+1 }}</td>
                  <td class="center">{{ $item->libelle }}</td>
                  <td class="center">{{ $item->ville }}</td>
                  <td class="center">{{ $item->agent }}</td>
                  <td class="center">{{ $item->telephone }}</td>
                  <td class="center">{{ $item->email }}</td>
                  <td class="center">{{ $item->adresse }}</td>
                  <td class="center">{{ $item->description }}</td>
                  <td class="center">{{ getDateHelper($item->created_at)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <p>&nbsp;</p>

    </div>
</body>
</html>

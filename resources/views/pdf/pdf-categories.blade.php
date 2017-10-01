<html>
<head>
<title>Liste des catégories</title>
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
        border-right: 1px solid;
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
                  <th width="70%" colspan="3">
                      <center>Magasin N° 3 Bloc A1 Residence Tifaouine </center>
                        <center>Av. Moukaouama Agadir </center>
                        <center>Tel : 0528 844 727   Fax : 0528 844 710  </center>

                  </th>
                </tr>
                  <tr>
                  <th width="70%" colspan="3">
                      <h1><center>Liste des Categories</center></h1><br>

                  </th>
              </tr>
          </thead>
      </table>

      <p>&nbsp;</p>

        <table width="100%" class="outline-table">
            <tbody>
                <tr class="border-bottom border-right grey">
                    <td colspan="3"><center><strong>Liste des catégories</strong></td>
                </tr>
                <tr class="border-bottom border-right center">
                    <td width="5%"><strong> # </strong></td>
                    <td width="40%"><strong>Libellé Catégorie</strong></td>
                    <td><strong>Description</strong></td>
                </tr>
                @foreach($data as $item)
                <tr class="border-right">
                  <td class="pad-left">{{ $loop->index+1 }}</td>
                  <td class="center">{{ $item->libelle }}</td>
                  <td class="right-center">{{ $item->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p>&nbsp;</p>

    </div>
</body>
</html>

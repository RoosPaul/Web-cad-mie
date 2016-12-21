(function($)
{
	$.fn.connect4=function(x, y, color1, color2)
	{
		if (x < 4)
			x = 4;
		if (y < 4)
			y = 4;
		var tab = [];
		var player = true;
		var play = true;
		var score1 = 0;
		var score2 = 0;
		var ligne = 0;
		var colonne = 0;
		var data = "";
		var res1 = color1.match(/^#[0-9A-F]{6}$/i);
		var res2 = color1.match(/^#[0-9A-F]{6}$/i);
		if (res1 === null)
			color1 = "yellow";
		if (res2 === null)
			color2 = "red";
		if (color1 === color2) {
			color1 = "yellow";
			color2 = "red";
		}
		$("head").append("<style>.yellow {background-color: "+ color1 +"; border-radius: 100%;}");
		$("head").append("<style>.red {background-color: "+ color2 +"; border-radius: 100%;}");
		$(this).append("<h1>Puissance 4</h1>");
		$(this).append("<table id='table' cellspacing='0'>");
		for (var i = 0; i < y; i++) {
			$("#table").append("<tr id=" + i + ">");
			tab [i] = [];
			for (var cpt2 = 0; cpt2 < x; cpt2++) {
				$("#" + i).append("<td id=" + i + cpt2 + "></td>");
				tab[i][cpt2] = 0;
			}
			$("#table").append("</tr>");
		}
		$(this).append("</table>");
		$(".player").text("Joueur 1 à toi de jouer");
		$(".player").css("background-color", color1);
		$(".score").text("Joueur 1 a remporté " + score1 + " manche(s) | Joueur 2 a remporté " + score2 + " manche(s)");

		$(".restart").on("click", function (e) {
			for (var i = 0; i < tab.length; i++) {
				for (var y = 0; y <tab[i].length; y++) {
					tab[i][y] = 0;
				}
			}
			$("td").removeClass("yellow");
			$("td").removeClass("red");
			play = true;
			player = true;
			$(".player").text("Joueur 1 à toi de jouer");
			$(".victory").text("");
			$(".player").css("background-color", color1);
		});

		$(".cancel").on("click", function (e) {
			tab[ligne][colonne] = 0;
			$("#" + ligne + colonne).removeClass("yellow");
			$("#" + ligne + colonne).removeClass("red");
			player = !player;
			play = true;
			$(".victory").text("");
			if (player) {
				$(".player").text("Joueur 1 à toi de jouer !");
				$(".player").css("background-color", color1);
			}
			else {
				$(".player").text("Joueur 2 à toi de jouer !");
				$(".player").css("background-color", color2);
			}
		});

		$("td").on("click", function (e) {
			$(".score").text("Joueur 1 a remporté " + score1 + " manche(s) | Joueur 2 a remporté " + score2 + " manche(s)");
			if (play === true) {
				data = $(this).attr("id");
				data = data.split("");
				ligne = y - 1;
				colonne = parseInt(data[1]);
				while (ligne >= 0) {
					if (tab[ligne][colonne] === 0) {
						if (player)
							tab[ligne][colonne] = 1;
						else
							tab[ligne][colonne] = 2;
							var height_animation = y * 100;
						if (player) {
							$("#" + ligne + colonne).css({top : "-" + height_animation + "px"}, 1000);
							$("#" + ligne + colonne).addClass("yellow");
							$("#" + ligne + colonne).animate({top : "0px"}, 1000);
						}
						else {
							$("#" + ligne + colonne).css({top : "-" + height_animation + "px"}, 1000);
							$("#" + ligne + colonne).addClass("red");
							$("#" + ligne + colonne).animate({top : "0px"}, 1000);
						}
						break;
					}
					else if (ligne === 0) {
						player = !player;
						break;
					}
					else
						ligne--;
				}
				var result_vertical = check_vertical(ligne, colonne);
				var result_horizontal = check_horizontal(ligne, colonne);
				var result_diagonal = check_diagonal(ligne, colonne);

				if (result_diagonal === true || result_horizontal === true || result_vertical === true) {
					if (player){
						console.log("victoire");
						play = false;
						score1++;
						$(".victory").text("victoire du joueur 1 !");
					}
					else {
						console.log("victoire");
						play = false;
						score2++;
						$(".victory").text("victoire du joueur 2 !");
					}
				}
				player = !player;

				if (player) {
					$(".player").text("Joueur 1 à toi de jouer !");
					$(".player").css("background-color", color1);
				}
				else {
					$(".player").text("Joueur 2 à toi de jouer !");
					$(".player").css("background-color", color2);
				}
			}
		});

		function check_vertical(my_ligne, my_colonne) {
			var buffer = 0;
			var check_ligne = x - 2;
			while (check_ligne >= 0) {
				if (player) {
					if (tab[check_ligne][my_colonne] === 1) {
						buffer++;
					}
					else{
						buffer = 0;
					}
					check_ligne--;
					if (buffer === 4){
						return true;
					}
				}
				else {
					if (tab[check_ligne][my_colonne] === 2) {
						buffer++;
					}
					else{
						buffer = 0;
					}
					check_ligne--;
					if (buffer === 4){
						return true;
					}
				}
			}
			return false;
		}

		function check_horizontal(my_ligne, my_colonne) {
			var buffer = 0;
			var check_colonne = my_colonne;
			if (player) {
				console.log("colonne : " + my_ligne);
				while(check_colonne >= 0) {
					if (tab[my_ligne][check_colonne] === 1) {
						buffer++;
					}
					else  {
						break;
					}
					check_colonne--;
					if (buffer === 4)
						return true;
				}
				check_colonne = my_colonne + 1;
				while(check_colonne < x) {
					if (tab[my_ligne][check_colonne] === 1) {
						buffer++;
					}
					else
						break;
					check_colonne++;
					if (buffer === 4)
						return true;
				}
			}
			if (!player) {
				while(check_colonne >= 0) {
					if (tab[my_ligne][check_colonne] === 2) {
						buffer++;
					}
					else
						break;
					check_colonne--;
					if (buffer === 4)
						return true;
				}

				check_colonne = my_colonne + 1;
				while(check_colonne < x) {
					if (tab[my_ligne][check_colonne] === 2) {
						buffer++;
					}
					else
						break;
					check_colonne++;
					if (buffer === 4)
						return true;
				}
			}
		}

		function check_diagonal(my_ligne, my_colonne) {
			var buffer = 0;
			var check_colonne = my_colonne;
			var check_ligne = my_ligne;
			if (player) {
			// check nord-ouest / sud-est
			while (check_colonne >= 0 && check_ligne >= 0) {
				if (tab[check_ligne][check_colonne] === 1) {
					buffer++;
				}
				else
					break;
				check_colonne--;
				check_ligne--;
			}
			check_colonne = my_colonne + 1;
			check_ligne = my_ligne + 1;

			while (check_colonne <= x && check_ligne < y) {
				if (tab[check_ligne][check_colonne] === 1) {
					buffer++;
				}
				else
					break;
				check_colonne++;
				check_ligne++;
			}
			if (buffer === 4)
				return true;


			//check sud-ouest / nord-est

			check_colonne = my_colonne;
			check_ligne = my_ligne;
			buffer = 0;
			while (check_colonne >= 0 && check_ligne < y) {
				if (tab[check_ligne][check_colonne] === 1) {
					buffer++;
				}
				else
					break;
				check_colonne--;
				check_ligne++;
			}
			if (my_colonne === 0)
				buffer++;

			check_colonne = my_colonne + 1;
			check_ligne = my_ligne - 1;

			while (check_colonne <= x && check_ligne >= 0) {
				if (tab[check_ligne][check_colonne] === 1) {
					buffer++;
				}
				else
					break;
				check_colonne++;
				check_ligne--;
			}
			if (buffer === 4)
				return true;
		}
		else {
			// check nord-ouest / sud-est
			while (check_colonne >= 0 && check_ligne >= 0) {
				if (tab[check_ligne][check_colonne] === 2) {
					buffer++;
				}
				else
					break;
				check_colonne--;
				check_ligne--;
			}
			check_colonne = my_colonne + 1;
			check_ligne = my_ligne + 1;

			while (check_colonne <= x && check_ligne < y) {
				if (tab[check_ligne][check_colonne] === 2) {
					buffer++;
				}
				else
					break;
				check_colonne++;
				check_ligne++;
			}
			if (buffer === 4)
				return true;


			//check sud-ouest / nord-est

			check_colonne = my_colonne;
			check_ligne = my_ligne;
			buffer = 0;
			while (check_colonne >= 0 && check_ligne < y) {
				if (tab[check_ligne][check_colonne] === 2) {
					buffer++;
				}
				else
					break;
				check_colonne--;
				check_ligne++;
			}
			if (my_colonne === 0)
				buffer++;

			check_colonne = my_colonne + 1;
			check_ligne = my_ligne - 1;

			while (check_colonne <= x && check_ligne >= 0) {
				if (tab[check_ligne][check_colonne] === 2) {
					buffer++;
				}
				else
					break;
				check_colonne++;
				check_ligne--;
			}
			if (buffer === 4)
				return true;
		}
	}
};
})(jQuery);

$(function () {
	$(".container").connect4(7, 6, "#FFFF00", "#FF0000");
});

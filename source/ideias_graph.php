<?

function SetColor ($color)
{
	if (!(strpos($color,'#')===false))
	{
		$r = hexdec(substr($color,1,2));
		$g = hexdec(substr($color,3,2));
		$b = hexdec(substr($color,5,2));
		
		return array ($r,$g,$b);
	}
	else
	{
		return $color;
	}
}

function AllocateColor(&$img,$color)
{
	list($r,$g,$b)=SetColor($color);
	//echo "<BR>$r-$g-$b<BR>";
	$result=ImageColorAllocate($img,$r,$g,$b);
	return $result;
}

class ideias_graph
{
	//include ('ideias_vars.inc');

	var $img;
	var $img_width=320;
	var $img_height=240;
	var $img_type='png';
	var $img_background;
	var $img_bgcolor="#FFFFFF";
	var $img_border=1;
	var $img_border_color="#000000";
	var $img_background_style="repeat"; //repeat or stretch
	var $img_font='VERDANA.TTF';
	var $img_box= array ('top'=>0,'left'=>0,'right'=>320, 'bottom'=>240);
	var $img_margin=4;

	var $data_colors=array("#000099","#009900","#990000");
	var $data_values;
	var $data_precision=0;
	var $data_thousand_sep= '.';
	var $data_decimal_sep=',';
	var $data_font='VERDANA.TTF';
	var $data_font_size=10;
	var $data_font_color="#000000";
	var $data_format="%"; // #-number %-percent
	var $changed_data_font=false;
	var $changed_data_font_color=false;	
	var $min_value;
	var $max_value;
	var $num_series; //number of data series
	var $chart_type="pie"; //pie,lines,bars
	
	var $graph_box;
	var $chart_border_color="#000000";
	
	var $legend;
	var $legend_position='bottom'; //top,bottom,topleft,topright,bottomleft,bottomright
	var $legend_font='VERDANA.TTF';
	var $changed_legend_font=0;
	var $legend_font_size=10;
	var $legend_border=1;
	var $legend_box_color="#ffffff";
	var $legend_box_border_color="#000000";
	var $legend_font_color="#000000";
	var $legend_box;
	
	var $draw_x_axis=0;
	var $draw_x_grid=0;
	var $x_axis_values;
	var $changed_x_axis_font=0;
	var $x_axis_font="VERDANA.TTF";
	var $x_axis_font_size=10;
	var $x_axis_width=1;
	var $x_axis_angle=0;
	var $x_axis_color="#000000";
	var $x_grid_color="#000000";
	
	var $x_axis_max_chars=10;	
	var $x_slices;
	
	var $draw_y_axis=0;
	var $draw_y_grid=0;
	var $changed_x_axis_font=0;
	var $y_axis_font="VERDANA.TTF";
	var $y_axis_font_size=10;
	var $y_axis_width=1;
	var $y_axis_angle=0;
	var $y_axis_color="#000000";
	var $y_grid_color="#000000";
	
	var $y_axis_max_chars=10;	
	var $y_slices;
	
	var $show_data_values = 1;	
	var $line_width = 1;
	var $dot_style = 'circle'; // none,diamond,circle,square;
	var $dot_size = 6; 	
	

	
	function SetYGridColor($acolor)
	{
		$this->y_grid_color=$acolor;
	}
	
	function SetXGridColor($acolor)
	{
		$this->x_grid_color=$acolor;
	}

	
	/*************************
	SetSQLChart ($con,$database,$sql,$x_axis_field,$y_axis_field)
	Creates a SQL based chart
	**************************/
	function SetSQLChart($con,$database,$sql,$x_axis_field,$y_axis_field,$num_series)
	{
		//PAREI AQUI DESENVOLVER INTERFACE SQL - PROBLEMA: COMO SABER O NÚMERO DE SÉRIES
		$res = mysql_db_query($database,$sql,$con);

	}			

	
	/*************************
	SetDotStyle($a_style,$a_size=6)
	Set Lines chart dot style and size
	**************************/
	function SetDotStyle($a_style,$a_size=6)
	{
		$this->dot_style=$a_style;
		$this->dot_size=$a_size;
	}
		
		
	
	/*************************
	SetLineWidth ($a_width)
	Set Lines chart width
	**************************/
	function SetLineWidth ($a_width)
	{
		$this->line_width = $a_width;
	}
	
	
	
	/*************************
	ShowDataValues ($yes)
	Toggle axis on/off
	**************************/
	function ShowDataValues ($status)
	{
		$this->show_data_values=$status;
	}
	
	
	/*************************
	DrawAxis ($x,$y)
	Toggle axis on/off
	**************************/
	function DrawAxis ($x,$y)
	{
		$this->draw_x_axis = $x;
		$this->draw_y_axis = $y;
	}
	
	
	/*************************
	SetXAxisValues ($a_values)
	Set X Axis Texts
	**************************/
	function SetXAxisValues ($a_values)
	{
		if (is_array($a_values))
		{
			$this->x_axis_values = $a_values;
		}
		else
			return false;
	}
	
	
	
	/*************************
	SetXAxisFont ($a_font,$a_font_size,$a_color,$a_width=1)
	format border color and width
	**************************/
	function SetXAxis ($a_font,$a_font_size,$a_color,$a_angle=0, $a_max_chars=6, $a_width=1)
	{
		$this->x_axis_font=$a_font;
		$this->x_axis_font_size=$a_font_size;
		$this->x_axis_width=$a_width;
		$this->x_axis_angle=$a_angle;
		$this->x_axis_color=$a_color;
		$this->x_axis_max_chars=$a_max_chars;
		$this->changed_x_axis_font=1;
	}
	
	/*************************
	SetXAxisColor ($a_color)
	format XAxis color 
	**************************/
	function SetXAxisColor ($a_color)
	{
		$this->x_axis_color=$a_color;
	}
	
	/*************************
	SetYAxisColor ($a_color)
	format YAxis color 
	**************************/
	function SetYAxisColor ($a_color)
	{
		$this->y_axis_color=$a_color;
	}
	
	
	
	/*************************
	SetYAxisFont ($a_font,$a_font_size,$a_color,$a_width=1)
	format border color and width
	**************************/
	function SetYAxis ($a_font,$a_font_size,$a_color,$a_angle=0, $a_max_chars=6, $a_width=1)
	{
		$this->y_axis_font=$a_font;
		$this->y_axis_font_size=$a_font_size;
		$this->y_axis_width=$a_width;
		$this->y_axis_angle=$a_angle;
		$this->y_axis_color=$a_color;
		$this->y_axis_max_chars=$a_max_chars;
		$this->changed_y_axis_font=1;
	}
	
	
	/*************************
	INTERNAL FUNCTION
	CalcXAxis ()
	calculates X axis size
	**************************/
	function CalcXAxis ()
	{
		$str=str_pad ($str,$this->x_axis_max_chars,'Ag');
		$max_size=$this->GetStringSize($str,$this->x_axis_font,$this->x_axis_font_size,$this->x_axis_angle);
		$this->x_axis_height = $max_size['height']+$this->x_axis_width+$this->img_margin;
		if (is_array($this->x_axis_values))
		{
			$size = $this->GetStringSize(substr ($this->x_axis_values[0],0,$this->x_axis_max_chars),$this->x_axis_font,$this->x_axis_font_size,$this->x_axis_angle);
			$this->x_axis_first_width=$size['width']/2+$this->img_margin/2;
			$size = $this->GetStringSize(substr ($this->x_axis_values[count($this->x_axis_values)-1],0,$this->x_axis_max_chars),$this->x_axis_font,$this->x_axis_font_size,$this->x_axis_angle);
			$this->x_axis_last_width=$size['width']/2+$this->img_margin/2;
		}
	}
	
	
	/*************************
	INTERNAL FUNCTION
	CalcYAxis ()
	calculates X axis size
	**************************/
	function CalcYAxis ()
	{
		// Parei aqui - calcular minimo e maximo de y
		$str=number_format($this->max_value,$this->data_precision,$this->data_decimal_sep, $this->data_thousand_sep);
		$size = $this->GetStringSize($str,$this->y_axis_font,$this->y_axis_font_size,$this->y_axis_angle);
		$this->y_axis_scale_width=$size['width']+$this->img_margin;
		$this->y_axis_first_height=$size['height'];
	}


	/*************************
	INTERNAL FUNCTION
	DrawYAxis ()
	draws Y axis
	**************************/
	function DrawYAxis ()
	{
		//if ($this->chart_type!='pie')
		{
			$result = $this->max_e_min($this->min_value,$this->max_value);
			$this->min_value=$result[0];
			$this->max_value=$result[1];
			$this->y_slices=11;
			//var_dump($result);
			
			
			
			$axis_color = AllocateColor ($this->img,$this->y_axis_color);
			if ($this->draw_y_grid)
			{
				$grid_color=AllocateColor($this->img,$this->y_grid_color);
			} 

			for ($f=0;$f<$this->y_axis_width;$f++)
			{
				ImageLine($this->img,$this->graph_box['left']+$f,$this->graph_box['top'],
						 $this->graph_box['left']+$f,$this->graph_box['bottom'],$axis_color);
			}	
			
			if ($this->show_data_values)
			{
				$size=$this->GetStringSize('Ag',$this->data_font,$this->data_font_size,0); 
				$slice_width=($this->graph_box['bottom']-$this->graph_box['top']-$size['height'])/($this->y_slices-1);
				$yi=$this->graph_box['top']+$this->y_axis_first_height+$size['height'];
			}	
			else
			{
				$slice_width=($this->graph_box['bottom']-$this->graph_box['top'])/($this->y_slices-1);
				$yi=$this->graph_box['top']+$this->y_axis_first_height;
	
			}
	 
			$start_value=$this->max_value;
			$increment = ($this->max_value-$this->min_value)/($this->y_slices-1);
			for ($f=0;$f<($this->y_slices);$f++)
			{
				$value = $start_value-($f*$increment);
				$str = number_format($value,$this->data_precision,$this->data_decimal_sep, $this->data_thousand_sep);
				$size=$this->GetStringSize($str,$this->x_axis_font,$this->x_axis_font_size,$this->x_axis_angle);
				$x = $this->graph_box['left']-$size['width'] - $this->img_margin;
				$y = $yi + ($slice_width*$f)-$size['height']/2;
				ImageLine ($this->img,$this->graph_box['left']-$this->img_margin/2,$y-$size['height']/2,
							$this->graph_box['left'],$y-$size['height']/2,$axis_color);				
				ImageTTFText ($this->img,$this->y_axis_font_size,$this->y_axis_angle,$x,$y,
							$axis_color,$this->x_axis_font,$str);
				if ($this->draw_y_grid)
				{

					ImageLine ($this->img,$this->graph_box['left'],$y-$size['height']/2,
							   $this->graph_box['right'],$y-$size['height']/2,$grid_color);
				}
			}
		}
	}
	
	
	
	/*************************
	INTERNAL FUNCTION
	DrawXAxis ()
	draws X axis
	**************************/
	function DrawXAxis ()
	{
		if ($this->draw_x_grid)
		{
			$grid_color=AllocateColor($this->img,$this->x_grid_color);
		} 
		
		$str=str_pad ($str,$this->x_axis_max_chars,'Ag');
		$max_size=$this->GetStringSize($str,$this->x_axis_font,$this->x_axis_font_size,$this->x_axis_angle);

		$color = AllocateColor ($this->img,$this->x_axis_color);
		for ($f=0;$f<$this->x_axis_width;$f++)
		{
			ImageLine($this->img,$this->graph_box['left'],$this->graph_box['bottom']+$f,
					 $this->graph_box['right'],$this->graph_box['bottom']+$f,$color);
		}	 
		if (is_array($this->x_axis_values))
		{
			$slice_width=($this->graph_box['right']-$this->graph_box['left'])/($this->x_slices);
			$slice_width=($this->graph_box['right']-$this->graph_box['left']-$slice_width)/($this->x_slices-1);
			
			$xi=$this->graph_box['left']+$slice_width/2;
			//PAREI AQUI CALCULAR TAMANHO DAS BARRAS
			foreach ($this->x_axis_values as $value)
			{
				$str = substr ($value,0,$this->x_axis_max_chars);
				$size=$this->GetStringSize($str,$this->x_axis_font,$this->x_axis_font_size,$this->x_axis_angle);
				$y = $this->graph_box['bottom']+$max_size['height']+$this->y_axis_font_size/2;
				$x=$xi;
				ImageLine ($this->img,$x,$this->graph_box['bottom'],$x,$this->graph_box['bottom']+$this->img_margin/2,$color);
				if ($this->draw_x_grid)
				{
					ImageLine ($this->img,$x,$this->graph_box['top'],$x,$this->graph_box['bottom'],$grid_color);
				}
				$x = $xi-$size['width']/2;
				ImageTTFText ($this->img,$this->x_axis_font_size,$this->x_axis_angle,$x,$y,
						$color,$this->x_axis_font,$str);
				$xi += $slice_width;
			}
		}
	}
	

	/*************************
	INTERNAL FUNCTION
	DrawBars ()
	draws Bars chart
	**************************/
	function DrawBars ()
	{
		if (is_array($this->data_values))
		{
			if ($this->x_slices>1)
			{
				$slice_width=($this->graph_box['right']-$this->graph_box['left'])/($this->x_slices);
				$slice_width=($this->graph_box['right']-$this->graph_box['left']-$slice_width)/($this->x_slices-1);
				$bar_width = $slice_width/$this->num_series - $slice_width/8;
				$xi=$this->graph_box['left']+$slice_width/2 - ($bar_width*$this->num_series)/2;
			}
			else
			{
				$slice_width=($this->graph_box['right']-$this->graph_box['left'])/($this->x_slices) - ($this->graph_box['right']-$this->graph_box['left'])/($this->x_slices)*0.4 ;
				$bar_width = $slice_width/$this->num_series - $slice_width/8;
				$xi = ($this->graph_box['right']- $this->graph_box['left'] - $slice_width)/2; 
		 	}
			
			$count_color=0;
			
			if ($this->show_data_values)
			{
				$size=$this->GetStringSize('Ag',$this->data_font,$this->data_font_size,0); 
				$unity=($this->graph_box['bottom']-$this->graph_box['top']-$size['height'])/($this->max_value-$this->min_value);
			}
			else
			{
				$unity=($this->graph_box['bottom']-$this->graph_box['top'])/($this->max_value-$this->min_value);
			}
		    if ($this->num_series>1)
			{
				foreach ($this->data_values as $row)
				{
					$count_color=0;
					foreach ($row as $key=>$value)
					{
						if($key<count($this->data_colors))
						{
							//echo $this->data_colors[$key];
							$data_color=AllocateColor($this->img,$this->data_colors[$key]);
						}
						else
						{
							$data_color=AllocateColor($this->img,$this->data_colors[$count]);
							$count_color++;
							if ($coun_colort>=count($this->data_colors))
								$count_color=0;
						}
						$yf = $this->graph_box['bottom']-($unity*($value-$this->min_value));
						ImageFilledRectangle($this->img,$xi, $yf,$xi+$bar_width,$this->graph_box['bottom'],$data_color);
						if ($this->show_data_values)
						{
							$str=number_format($value,$this->data_precision,$this->data_decimal_sep, $this->data_thousand_sep);			
							$size=$this->GetStringSize($str,$this->data_font,$this->data_font_size,0);
							ImageTTFText ($this->img,$this->data_font_size,0,($xi+$xi+$bar_width-$size['width'])/2,
										$yf-$size['height'],
										$data_color,$this->data_font,$str);				
						}
						$xi = round ($xi+$bar_width);
					}
					$xi += $slice_width/8 *$this->num_series ;
				}
			}
			else
			{
				foreach ($this->data_values as $key=>$value)
				{
					if($key <count($this->data_colors))
					{
						//echo $this->data_colors[$key];
						$data_color=AllocateColor($this->img,$this->data_colors[$key]);
					}
					else
					{
						$data_color=AllocateColor($this->img,$this->data_colors[$count]);
						$count_color++;
						if ($coun_colort>=count($this->data_colors))
							$count_color=0;
					}
					$yf = $this->graph_box['bottom']-($unity*($value-$this->min_value));
					ImageFilledRectangle($this->img,$xi, $yf,
							$xi+$bar_width,$this->graph_box['bottom'],$data_color);
					if ($this->show_data_values)
					{
						$str=number_format($value,$this->data_precision,$this->data_decimal_sep, $this->data_thousand_sep);			
						$size=$this->GetStringSize($str,$this->data_font,$this->data_font_size,0);
						ImageTTFText ($this->img,$this->data_font_size,0,($xi+$xi+$bar_width-$size['width'])/2,
									$yf-$size['height']/2,$data_color,$this->data_font,$str);				
					}
					$xi = round ($xi+$slice_width);
				}
			}
		}
		
	}


	/*************************
	INTERNAL FUNCTION
	DrawDot ($x,$y)
	draws Lines chart dots
	**************************/
	function DrawDot ($x,$y,$color)
	{
		switch ($this->dot_style)
		{
			case 'circle':
				ImageArc ($this->img,$x,$y, $this->dot_size,$this->dot_size, 0,360, $color);
				ImageFillToBorder($this->img,$x+1,$y+1,$color,$color);
				return $this->dot_size/2;
				break;
			case 'square':
				ImageFilledRectangle($this->img,$x-$this->dot_size/2,$y-$this->dot_size/2,$x+$this->dot_size/2,$y+$this->dot_size/2,$color);
				return $this->dot_size/2;
				break;
			case 'diamond':
				ImageLine($this->img,$x-$this->dot_size/2,$y,$x,$y-$this->dot_size/2,$color);
				ImageLine($this->img,$x-$this->dot_size/2,$y,$x,$y+$this->dot_size/2,$color);
				ImageLine($this->img,$x+$this->dot_size/2,$y,$x,$y-$this->dot_size/2,$color);
				ImageLine($this->img,$x+$this->dot_size/2,$y,$x,$y+$this->dot_size/2,$color);
				ImageFillToBorder($this->img,$x+1,$y+1,$color,$color);
				return $this->dot_size/2;
				break;
			default:
				return 0;
		}
		
	}


	/*************************
	INTERNAL FUNCTION
	DrawLines ()
	draws Lines chart
	**************************/
	function DrawLines ()
	{
		if ($this->changed_data_font_color)
			$data_font_color=AllocateColor($this->img,$this->data_font_color);
		
		if (is_array($this->data_values))
		{
			$slice_width=($this->graph_box['right']-$this->graph_box['left'])/($this->x_slices);
			$slice_width=($this->graph_box['right']-$this->graph_box['left']-$slice_width)/($this->x_slices-1);

			$count_color=0;
			if ($this->show_data_values)
			{
				$size=$this->GetStringSize('Ag',$this->data_font,$this->data_font_size,0); 
				$unity=($this->graph_box['bottom']-$this->graph_box['top']-$size['height'])/($this->max_value-$this->min_value);
			}
			else
			{
				$unity=($this->graph_box['bottom']-$this->graph_box['top'])/($this->max_value-$this->min_value);
			}
		    if ($this->num_series>1)
			{
				$series=0;
				$item=0;
				$count_color=0;
				$xi=$this->graph_box['left'] +$slice_width/4;
				for ($item=0;$item<count($this->data_values[0]);$item++)
				{
					$data_color=AllocateColor($this->img,$this->data_colors[$count_color++]);
					if ($count_color>=count($this->data_colors))
						$count_color=0;
					$xi=$this->graph_box['left'] +$slice_width/2;

					for ($series=1;$series<$this->num_series;$series++)
					{
						$yi = $this->graph_box['bottom']-($unity*($this->data_values[$series-1][$item]-$this->min_value));
						$yf = $this->graph_box['bottom']-($unity*($this->data_values[$series][$item]-$this->min_value));
						$dot_size=$this->DrawDot($xi,$yi,$data_color);
						if ($this->show_data_values)
						{
							$str=number_format($this->data_values[$series-1][$item],
												$this->data_precision,$this->data_decimal_sep, $this->data_thousand_sep);			
							$size=$this->GetStringSize($str,$this->data_font,$this->data_font_size,0);
							ImageTTFText ($this->img,$this->data_font_size,0,$xi-$size['width']/2,
										$yi-($size['height']/2)-$dot_size,$data_color,$this->data_font,$str);				
						}		
						for ($f=0;$f<$this->line_width;$f++)
							ImageLine($this->img,$xi+$f, $yi+$f,$xi+$f+$slice_width,$yf+$f,$data_color);
						$xi += $slice_width;
					}
					$this->DrawDot($xi,$yf,$data_color);
					if ($this->show_data_values)
					{
						$str=number_format($this->data_values[$series-1][$item],
											$this->data_precision,$this->data_decimal_sep, $this->data_thousand_sep);			
						$size=$this->GetStringSize($str,$this->data_font,$this->data_font_size,0);
						if (!$this->changed_data_font_color)
						{
							ImageTTFText ($this->img,$this->data_font_size,0,$xi-$size['width']/2,
									$yf-$size['height']/2-$dot_size,$data_color,$this->data_font,$str);				
						}
						else
						{
							ImageTTFText ($this->img,$this->data_font_size,0,$xi-$size['width']/2,
									$yf-$size['height']/2-$dot_size,$data_font_color,$this->data_font,$str);				
						}
					}

				}
			}
			else
			{
				$xi=$this->graph_box['left'] +$slice_width/2;
				$data_color=AllocateColor($this->img,$this->data_colors[0]);
				$yi = $this->graph_box['bottom']-($unity*($this->data_values[$item-1]-$this->min_value));
				for ($item=1;$item<count($this->data_values);$item++)
				{
					$yi = $this->graph_box['bottom']-($unity*($this->data_values[$item-1]-$this->min_value));
					$yf = $this->graph_box['bottom']-($unity*($this->data_values[$item]-$this->min_value));
					$dot_size=$this->DrawDot($xi,$yi,$data_color);
					if ($this->show_data_values)
					{
						$str=number_format($this->data_values[$item-1],
											$this->data_precision,$this->data_decimal_sep, $this->data_thousand_sep);			
						$size=$this->GetStringSize($str,$this->data_font,$this->data_font_size,0);
						if (!$this->changed_data_font_color)
						{
							ImageTTFText ($this->img,$this->data_font_size,0,$xi-$size['width']/2,
									$yi-$size['height']/2-$dot_size,$data_color,$this->data_font,$str);				
						}
						else
						{
							ImageTTFText ($this->img,$this->data_font_size,0,$xi-$size['width']/2,
									$yi-$size['height']/2-$dot_size,$data_font_color,$this->data_font,$str);				
						}
					}
					for ($f=0;$f<$this->line_width;$f++)
							ImageLine($this->img,$xi+$f, $yi+$f,$xi+$f+$slice_width,$yf+$f,$data_color);
					$xi += $slice_width;
				}
				$this->DrawDot($xi,$yf,$data_color);
				if ($this->show_data_values)
				{
					$str=number_format($this->data_values[$item-1],
										$this->data_precision,$this->data_decimal_sep, $this->data_thousand_sep);			
					$size=$this->GetStringSize($str,$this->data_font,$this->data_font_size,0);
					if (!$this->changed_data_font_color)
					{
						ImageTTFText ($this->img,$this->data_font_size,0,$xi-$size['width']/2,
								$yf-$size['height']/2-$dot_size,$data_color,$this->data_font,$str);				
					}
					else
					{
						ImageTTFText ($this->img,$this->data_font_size,0,$xi-$size['width']/2,
								$yf-$size['height']/2-$dot_size,$data_font_color,$this->data_font,$str);				
					}		
				}

			}			
		}
		
	}








	

	/*************************
	SetBorder ($a_color,$a_border=1)
	format border color and width
	**************************/

	function SetBorder ($a_color,$a_border=1)
	{
		$this->img_border_color=$a_color;
		$this->img_border=$a_border;
		$this->graph_box['top'] += $a_border;
		$this->graph_box['left'] += $a_border;
		$this->graph_box['bottom'] -= $a_border;
		$this->graph_box['right'] += $a_border;
	}



	/*************************
	SetChartBorderColor ($a_color)
	format graphic border color
	**************************/
	function SetChartBorderColor ($a_color)
	{
		$this->chart_border_color=$a_color;
	}

		
	/*************************
	SetLegendFont ($a_font_color,$a_font_size=0,$a_font=0)
	format Legend Font
	**************************/
	function SetLegendFont ($a_font_color,$a_font_size=0,$a_font=0)
	{
		$this->legend_font_color=$a_font_color;
		if ($a_font_size)
			$this->legend_font_size=$a_font_size;
		if ($a_font)
		{
			$this->legend_font=$a_font;
			$this->changed_legend_font=1;
		}
		
	}

	
	/*************************
	SetLegendBoxFormat ($a_box_color,$a_box_border_color,$a_border=1)
	$a_position=top,bottom,topleft,topright,bottomleft,bottomright
	format Legend Box
	**************************/
	function SetLegendBoxFormat ($a_box_color,$a_box_border_color,$a_border=1)
	{
		$this->legend_box_color=$a_box_color;
		$this->legend_box_border_color=$a_box_border_color;
		$this->legend_border=$a_border;
	}
	
	
	/*************************
	SetDataFormat ($a_format,$a_font,
					$a_font_size,$a_data_precision=0,
					$a_thousand='.',$a_decimal=',')
	format data display
	$a_format = '#' - number
				'%' - percentual
	**************************/
	function SetDataFormat ($a_format,$a_font,$a_font_size,$a_data_precision=0,
							$a_thousand='.',$a_decimal=',')
	{
		$this->data_format=$a_format;
		$this->data_font=$a_font;
		$this->data_font_size=$a_font_size;
		$this->data_precision=$a_data_precision;
		$this->data_thousand_sep=$a_thousand;
		$this->data_decimal_sep=$a_decimal;
		$this->changed_data_font=true;
	}
	
	/*************************
	SetDataFontColor ($a_font_color)
	Set data font display
	**************************/
	function SetDataFontColor ($a_font_color)
	{
		$this->data_font_color=$a_font_color;
		$this->changed_data_font_color=true;
	}
		
	/*************************
	INTERNAL FUNCTION
	GetStringSize($a_str,$a_font,$a_angle=0)
	returns array with string size 
	**************************/
	function GetStringSize($a_str,$a_font,$a_size,$a_angle=0)
	{
		$arr=ImageTTFBBox ($a_size, $a_angle, $a_font, $a_str);
		
		/*0 lower left corner, X position 
		1 lower left corner, Y position 
		2 lower right corner, X position 
		3 lower right corner, Y position 
		4 upper right corner, X position 
		5 upper right corner, Y position 
		6 upper left corner, X position 
		7 upper left corner, Y position 
		*/
		switch($a_angle) 
		{
			case 0:
				$width 	= $arr[4] - $arr[6];
				$height = $arr[3] - $arr[5];
				break;
			case 90:
				$height = $arr[5] - $arr[1];
				$width = $arr[2] - $arr[4];
				break;
			case 45:
				$height = $arr[5] - $arr[1];
				$width = $arr[2] - $arr[4];
				break;
			default:
				$width = 0;
				$height = 0;
				break;
		}
		$ret['width']=abs($width);
		$ret['height']=abs($height);
		return $ret;
	}
	

	/*************************
	INTERNAL FUNCTION
	CalcGraphBox()
	Calculates graph box
	**************************/
	function CalcGraphBox()
	{
		$top=$this->img_box['top']+$this->img_border+$this->img_margin;
		$bottom=$this->img_box['bottom']-$this->img_border-$this->img_margin;
		$left=$this->img_box['left']+$this->img_border+$this->img_margin;
		$right=$this->img_box['right']-$this->img_border-$this->img_margin;
		
		// discounts legend
		if (is_array($this->legend))
		{
			switch ($this->legend_position)
			{
				case 'bottom':
					$bottom = $this->legend_box['top']-$this->img_margin;
					break;
				case 'top':
					$top = $this->legend_box['bottom']+$this->img_margin;
			}
		}
		
		// discounts x axis height
		if ($this->draw_x_axis)
		{
			$bottom -= $this->x_axis_height;
			$left +=$this->x_axis_first_width;
			$right -=$this->x_axis_last_width;
		}
		
		// discounts y axis width
		if ($this->draw_y_axis)
		{
			if ($this->x_axis_first_width<$this->y_axis_scale_width)
				$left +=($this->y_axis_scale_width-$this->x_axis_first_width);
			$top += $this->y_axis_first_height/2;
		}
		
		$this->graph_box['top']=$top;
		$this->graph_box['bottom']=$bottom;
		$this->graph_box['left']=$left;
		$this->graph_box['right']=$right;
	}	
		
		
	/*************************
	INTERNAL FUNCTION
	DrawPie()
	Draws pie chart
	**************************/
	function DrawPie()
	{
		$color=AllocateColor($this->img,$this->chart_border_color);
		
		$radius=min($this->graph_box['bottom']-$this->graph_box['top'],
					$this->graph_box['right']-$this->graph_box['left'])/2;
		$center_y=($this->graph_box['bottom']+$this->graph_box['top'])/2;
		$center_x=($this->graph_box['right']+$this->graph_box['left'])/2; 
		
		ImageArc ($this->img,$center_x,$center_y, $radius*2,$radius*2, 0,360, $color);

		$sum=0;
		foreach($this->data_values as $value)
		{
			$sum += $value;
		}
		$count=0;
		$xf=$center_x;
		$yf=$center_y-$radius;
		$angle=0;
		ImageLine($this->img,$center_x,$center_y,$xf,$yf,$color);
		$f=0;
		//Draws slices
		//var_dump($this->data_values);
		foreach ($this->data_values as $key=>$value)
		{
			$percent=$value/$sum;
			$angle+=$percent*360;
			$half_angle=$angle-$percent*180;
			$xf = $center_x+ $radius * sin(deg2rad($angle));
			$yf = $center_y - $radius * cos(deg2rad($angle)); 
			$half_xf = $center_x+ $radius * sin(deg2rad($half_angle));
			$half_yf = $center_y - $radius * cos(deg2rad($half_angle)); 
			if ($f<count($this->data_values)-1)
			{
				ImageLine($this->img,$center_x,$center_y,$xf,$yf,$color);
			}
			//echo $key;
			if($key <count($this->data_colors))
			{
				//echo $this->data_colors[$key];
				$data_color=AllocateColor($this->img,$this->data_colors[$key]);
			}
			else
			{
				$data_color=AllocateColor($this->img,$this->data_colors[$count]);
				$count++;
				if ($count>=count($this->data_colors))
					$count=0;
			}
			$size=$this->GetStringSize($str,$this->data_font,$this->data_font_size,0);
			$slice_center_x=($half_xf+$center_x)/2;
			$slice_center_y=($half_yf+$center_y)/2;
			ImageFillToBorder($this->img,$slice_center_x,$slice_center_y,$color,$data_color);
			$f++;
		}
		
		$xf=$center_x;
		$yf=$center_y-$radius;
		$angle=0;
		
		$data_font_color=AllocateColor($this->img,$this->data_font_color);
		//Draws numbers
		$pos_variacao=-1;
		foreach ($this->data_values as $key=>$value)
		{		
			$percent=$value/$sum;
			$angle+=$percent*360;
			$half_angle=$angle-$percent*180;
			$xf = $center_x+ $radius * sin(deg2rad($angle));
			$yf = $center_y - $radius * cos(deg2rad($angle)); 
			$half_xf = $center_x+ $radius * sin(deg2rad($half_angle));
			$half_yf = $center_y - $radius * cos(deg2rad($half_angle)); 
				$slice_center_x=($half_xf+$center_x)/2;
			if ($this->data_format=='%')
			{	
				$val=($percent*100);
				$uni="%";
			}
			else
				$val=$value;
			$str=number_format($val,$this->data_precision,$this->data_decimal_sep, $this->data_thousand_sep);
			$str .=$uni;
			$size=$this->GetStringSize($str,$this->data_font,$this->data_font_size,0);
			$slice_center_x=($half_xf+$center_x)/2;
			
			$slice_center_y=($half_yf+$center_y)/2 + ($size['height']+2) * $pos_variacao;
			if (++$pos_variacao > 2)
				$pos_variacao=-1;
			$slice_center_x -= $size['width']/2;
			ImageTTFText ($this->img,$this->data_font_size,0,$slice_center_x,$slice_center_y,
				$data_font_color,$this->data_font,$str);
		}
	
	}
	
	/*************************
	INTERNAL FUNCTION
	DrawLegend()
	Draws Legend Size
	**************************/
	function DrawLegend()
	{
		//$this->CalcLegendSizePos();
		if (is_Array ($this->legend))
		{
			if ($this->legend_box_color)
			{			
				$fillcolor=AllocateColor($this->img,$this->legend_box_color);
				ImageFilledRectangle($this->img,$this->legend_box['left'], $this->legend_box['top'],
							$this->legend_box['right'],$this->legend_box['bottom'],$fillcolor);
			}
			if ($this->legend_box_border_color)
			{
				$color=AllocateColor($this->img,$this->legend_box_border_color);
				ImageRectangle($this->img,$this->legend_box['left'], $this->legend_box['top'],
							$this->legend_box['right'],$this->legend_box['bottom'],$color);
			}
			
			$x=$this->legend_box['left']+$this->img_margin;
			$yf=$this->legend_box['top']+$this->img_margin+$this->legend_font_height;
			$color=AllocateColor($this->img,$this->legend_font_color);
			$count=0;
			foreach($this->legend as $key=>$legend)
			{
				$size=ImageTTFText ($this->img,$this->legend_font_size,0,$x,$yf,
							$color,$this->legend_font,$legend);
				$acolor=ImageColorAllocate($this->img,255,0,0);
				$xi=$this->legend_box['right']-$this->legend_font_height-$this->img_margin;
				$xf=$this->legend_box['right']-$this->img_margin;
				$yi=$yf-$this->legend_font_height;
				ImageRectangle($this->img,$xi,$yi,$xf,$yf,$color);
				if ($key<count($this->data_colors))
					$data_color=AllocateColor($this->img,$this->data_colors[$key]);
				else
				{
					$data_color=AllocateColor($this->img,$this->data_colors[$count++]);
					if ($count>=count($this->data_colors))
						$count=0;
				}
				ImageFilledRectangle($this->img,$xi,$yi,$xf,$yf,$data_color);
				$yf += $this->legend_font_height*1.5;
			}
		}
	}	
	

	/*************************
	INTERNAL FUNCTION
	CalcLegendSizePos()
	Calculates Legend Size
	**************************/
	function CalcLegendSizePos()
	{
		if (is_array($this->legend))
		{
			$legend_width=0;
			foreach ($this->legend as $legend)
			{
				$size=$this->GetStringSize($legend,$this->legend_font,$this->legend_font_size,0);
				if ($size['width']>$legend_width)
					$legend_width=$size['width'];
			}
			$size=$this->GetStringSize('Ag',$this->legend_font,$this->legend_font_size,0);
			$this->legend_font_height = $size['height'];
			$this->legend_width = $legend_width + $this->legend_border*2 + $this->img_margin*4+$this->legend_font_height;
			$this->legend_height = count($this->legend) * (($size['height']*1.5))+$this->img_margin;
			switch ($this->legend_position)
			{
				case 'top':
					$this->legend_box['top']=$this->img_box['top']+$this->img_border+$this->img_margin;
					$this->legend_box['left']=$this->img_box['left']+$this->img_border+$this->img_margin;
					$this->legend_box['bottom']=$this->legend_height+$this->legend_box['top'];
					$this->legend_box['right']=$this->img_box['right']-$this->img_border-$this->img_margin;
					break;
				case 'topleft':
					$this->legend_box['top']=$this->img_box['top']+$this->img_border+$this->img_margin;
					$this->legend_box['left']=$this->img_box['left']+$this->img_border+$this->img_margin;
					$this->legend_box['bottom']=$this->legend_height+$this->legend_box['top'];
					$this->legend_box['right']=$this->legend_box['left']+$this->legend_width;
					break;
				case 'topright':
					$this->legend_box['top']=$this->img_box['top']+$this->img_border+$this->img_margin;
					$this->legend_box['right']=$this->img_box['right']-$this->img_border-$this->img_margin;
					$this->legend_box['left']=$this->legend_box['right']-$this->legend_width;
					$this->legend_box['bottom']=$this->legend_height+$this->legend_box['top'];
					break;
				case 'bottomleft':
					$this->legend_box['bottom']=$this->img_box['bottom']-$this->img_border-$this->img_margin;
					$this->legend_box['top']=$this->legend_box['bottom'] - $this->legend_height;
					$this->legend_box['left']=$this->img_box['left']+$this->img_border+$this->img_margin;
					$this->legend_box['right']=$this->legend_box['left']+$this->legend_width;
					break;
				case 'bottomright':
					$this->legend_box['bottom']=$this->img_box['bottom']-$this->img_border-$this->img_margin;
					$this->legend_box['top']=$this->legend_box['bottom'] - $this->legend_height;
					$this->legend_box['right']=$this->img_box['right']-$this->img_border-$this->img_margin;
					$this->legend_box['left']=$this->legend_box['right']-$this->legend_width;
					break;					
				default: //bottom
					$this->legend_box['bottom']=$this->img_box['bottom']-$this->img_border-$this->img_margin;
					$this->legend_box['top']=$this->legend_box['bottom'] - $this->legend_height;
					$this->legend_box['left']=$this->img_box['left']+$this->img_border+$this->img_margin;
					$this->legend_box['right']=$this->img_box['right']-$this->img_border-$this->img_margin;
			}
		}
	}		
	
	
	
	/*************************
	SetFont($a_font,$a_color=0)
	Sets chart font
	**************************/
	function SetFont($a_font,$a_color=0)
	{
		if (file_exists($a_font))
		{
			if ($a_color)
			{
				$this->x_axis_color=$a_color;
				$this->x_axis_color=$a_color;
				$this->legend_color=$a_color;
			}
			$this->img_font=$a_font;
			if (!$this->changed_legend_font)
			{
				$this->legend_font = $a_font;
			}
			if (!$this->changed_x_axis_font)
			{
				$this->x_axis_font=$a_font;
			}
			if (!$this->changed_y_axis_font)
			{
				$this->y_axis_font =$a_font;
			}
			if (!$this->changed_data_font)
			{
				$this->data_font=$a_font;
			}
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	
	
	/*************************
	SetLegendPosition($a_legend)
	Sets chart legend position
	**************************/
	function SetLegendPosition($a_legend)
	{
		switch ($a_legend)
		{
			case 'top':
			case 'bottom':
			case 'topright':
			case 'topleft':
			case 'bottomright':
			case 'bottomleft':
				$this->legend_position=$a_legend;
				return true;
				break;
			default:
				return false;
		}
	}
	
	

	
	/*************************
	SetLegend($a_legend)
	Sets chart legend
	**************************/
	function SetLegend($a_legend)
	{
		if (is_array($a_legend))
		{
		 	$this->legend=$a_legend;
			return true;
		}
		else
			return false;
	}
	
	
				
	
	
	/*************************
	SetDataColors($a_colors)
	Sets chart data colors
	**************************/
	function SetDataColors($a_colors)
	{
		$this->data_colors=$a_colors;
	}
	


	/*************************
	SetChartType($a_type)
	Sets data values
	**************************/
	function SetChartType($a_type)
	{
		switch ($a_type)
		{
			case 'pie':
			case 'lines':
			case 'bars':
				$this->chart_type=$a_type;
				return true;
				break;
			default:
				return false;
		}
	}
	
	
	
	/*************************
	SetDataValues($a_data)
	Sets data values
	**************************/
	function SetDataValues($a_data)
	{
		$this->data_values=$a_data;
		$min=0;
		$max=0;
		$num_series=0;
		foreach ($a_data as $row)
		{
			if (is_array ($row))
			{
				foreach ($row as $value)
				{
					if (($min>$value) || ($min==0))
					{
						$min=$value;
					}
 					if (($max<$value) || ($max==0))
					{
						$max=$value;
					}
				}
				$num_series =count ($row);
			}
			else
			{
				if (($min>$row) || ($min==0))
				{
					$min=$row;
				}
					if (($max<$row) || ($max==0))
				{
					$max=$row;
				}
			}
		}
		if ($num_series==0)
			$num_series++;
		$this->min_value=$min;
		$this->max_value=$max;
		
		$this->num_series=$num_series;
		$this->x_slices=count($a_data);
	}

	
	
	/*************************
	SetImageSize($width,$height)
	Set image size
	**************************/
	function SetImageSize($a_width,$a_height)
	{
		$this->img_width=$a_width;
		$this->img_height=$a_height;
		$margin= $a_width*0.015; // creates a margin of 2% of image width
		$this->img_box['top']=0;
		$this->img_box['left']=0;
		$this->img_box['right']=$a_width;
		$this->img_box['bottom']=$a_height;
		$this->img_margin=$margin;
	}

	function DrawYGrid($set)
	{
		$this->draw_y_grid=$set;
	}
	
	function DrawXGrid($set)
	{
		$this->draw_x_grid=$set;
	}
	
	
	/*************************
	DrawImage()
	Draw image
	**************************/
	function DrawImage()
	{	
		if (is_Array ($this->legend))
		{
			$this->CalcLegendSizePos();
		}
		if (isset ($this->draw_x_axis))
		{
			$this->CalcXAxis();
		}
		if (isset ($this->draw_y_axis))
		{
			$this->CalcYAxis();
		}
		$this->CalcGraphBox();
		if (isset($this->img_bgcolor))
		{
			$color=AllocateColor($this->img,$this->img_bgcolor);
			ImageFilledRectangle($this->img,0,0,$this->img_width,$this->img_height,$color);
		}
		
		if (isset ($this->img_background))
		{
			$this->DrawBackgroundImage();
		}
		if ($this->img_border)
		{
			$color=AllocateColor($this->img,$this->img_border_color);
			for ($f=0;$f<$this->img_border;$f++)
				ImageRectangle($this->img,0+$f,0+$f,$this->img_width-$f-1,$this->img_height-$f-1,$color);
		}
		
		if ($this->draw_x_axis)
		{
			$this->DrawXAxis();
		}
		
		if ($this->draw_y_axis)
		{
			$this->DrawYAxis();
		}
		
		if (isset ($this->legend))
		{
			$this->DrawLegend();
		}
		
		switch ($this->chart_type)
		{
			case 'pie':
				$this->DrawPie();
				break;
			case 'bars':
				$this->DrawBars();
				break;
			case 'lines':
				$this->DrawLines();
		}
	}


	/*************************
	SetBackgroundStyle($a_style)
	Sets background style: repeat or stretch
	**************************/
	function SetBackgroundStyle($a_style)
	{
		switch ($a_style)
		{
			case "repeat":
			case "stretch":
				$this->img_background_style=$a_style;
				return true;
				break;
			default:
				return false;
		}
	}
	
	
	/*************************
	INTERNAL FUNCTION
	DrawBackgroundImage()
	Creates background image
	**************************/
	function DrawBackgroundImage ()
	{
		if (isset ($this->img_background))
		{
			if (strpos ($this->img_background,'.png'))
			{
			 	$back_img=ImageCreateFromPNG ($this->img_background);
			}
			if (strpos ($this->img_background,'.jpg'))
			{
			 	$back_img=ImageCreateFromJPEG ($this->img_background);
			}
			$back_width=ImageSx($back_img);
			$back_height=ImageSy($back_img);
			if ($back_img)
			{
				switch ($this->img_background_style)
				{
					case 'repeat':
						$x=0;
						$y=0;
						while ($y<$this->img_height)
						{
							while ($x<$this->img_width)
							{
								ImageCopy ($this->img,$back_img,$x,$y,0,0,$back_width,$back_height);
								$x+=$back_width;
							}
							$x=0;
							$y += $back_height;
						}
						break;
					case 'stretch':
						ImageCopyResized ($this->img,$back_img,0,0,0,0,$this->img_width,$this->img_height,$back_width,$back_height);
						break;
				}
			}
		}
	}
	
	/*************************
	SetBackgroundColor($a_color)
	Sets background color
	**************************/
	function SetBackgroundColor($a_color)
	{
		$this->img_bgcolor = SetColor($a_color);
	}

	
	
	/*************************
	SetImageBackground($a_image)
	Sets a image background
	**************************/
	function SetImageBackground($a_image)
	{
		$this->img_background = $a_image;
	}

	
			
	/*************************
	INTERNAL FUNCTION
	CreateImage()
	Creates the image handle
	**************************/
	function CreateImage()
	{
		if (!isset($this->img))
		{
			$this->img=ImageCreate($this->img_width, $this->img_height);
		}
	}


	/*************************
	SetImageType($a_type)
	Sets de Image type (jpg,png)
	**************************/
	function SetImageType($a_type)
	{
		switch ($a_type)
		{
			case 'jpg':
				$this->img_type = 'jpg';
				break;
			default: 
				$this->img_type = 'png';
				break;
		}
	}
	

	/*************************
	INTERNAL FUNCTION
	SendImageHeader()
	Sends Image header (jpg,png)
	**************************/
	function SendImageHeader()
	{
		//header ("Content-type: image/".$this->img_type);
	}


	/*************************
	OutputImage()
	Outputs image on screen
	**************************/
	function OutputImage()
	{
		$this->SendImageHeader();
		$this->CreateImage();
		if(isset($this->chart_type)) $this->DrawImage();
		switch ($this->img_type)
		{
			case 'jpg':
				ImageJPEG($this->img);
				break;
				
			default: 
				ImagePNG($this->img);
				break;
		}
		ImageDestroy($this->img);
	}
	
	
	  function melhor_com_esta_potencia ($base, $busca_maior, $ordem_grandeza, $diferenca)
  {
    $valores = array (0 => 0.2, 10 => 0.1666666666666666667, 5 => 0.1333333333333333333, 2 => 0.1);  
    $pentelhesimo = $ordem_gandeza / 10000;
    foreach ($valores as $valor => $percentual) {
      if (! isset($melhor)){
        if ($valor == 0) {
          if ($busca_maior) {  
            $limite = $base + ($diferenca * $percentual);
            if (($limite >= 0) && ($base <= 0)){
              $melhor = 0;  
            }          
          } 
          else {
            $limite = $base - ($diferenca * $percentual);          
            if (($limite <= 0) && ($base >= 0)) {
              $melhor = 0;  
            }         
          }
        }
        else {     
          $atrator = $ordem_grandeza * $valor;
          if (abs((round($base / $atrator) - ($base / $atrator))) < $pentelhesimo) {
            $melhor = $base; 
          }
          else { 
            if ($busca_maior) {
              $ajuste = ceil($base / $atrator);
              $novo_valor = $ajuste * $atrator;
              $limite = $base + ($diferenca * $percentual);          
              if ($limite >= $novo_valor) {
                $melhor = $novo_valor;  
              }        
            }
            else {
              $ajuste = floor($base / $atrator); 
              $novo_valor = $ajuste * $atrator;
              $limite = $base - ($diferenca * $percentual);             
              if ($limite <= $novo_valor) {
                $melhor = $novo_valor;  
              }  
            }
          } 
        }
      }
      else {
        break;
      }
    }
    if (isset($melhor)) {
      return array (TRUE, $melhor);
    }
    else {
      return array (FALSE, FALSE); 
    }
  }
  
 
  function divisoes($menor, $maior, $potencia)
  {
    $divisores = array (10, 9, 8, 7, 6, 5, 4, 3, 2);
    
    $diferenca = $maior - $menor;
    $pentelhesimo = $potencia / 10000;
    $potencia *= 10;
    $potencias_tentadas = 0;
    $divisor = $divisores[0];
    $divisao = $diferenca / ($divisor * $potencia);
    $melhor_divisor = $divisor;
    if (abs(round($divisao) - $divisao) < $pentelhesimo) {
      $menor_diferencial = 0;
    }
    else {
      $menor_diferencial = (ceil($divisao) - $divisao) * $divisor;
      while ($potencias_tentadas < 2) {
        $potencia /= 10;
        $pentelhesimo = $potencia / 10000;
        foreach ($divisores as $divisor) {
          $divisao = $diferenca / ($divisor * $potencia);
          if (abs(round($divisao) - $divisao) < $pentelhesimo) {
            $menor_diferencial = 0;
            $melhor_divisor = $divisor;
            break 2;
          }
          else {
            $temp = (ceil($divisao) - $divisao) * $divisor;
            if ($temp < $menor_diferencial) {
              $menor_diferencial = $temp;
              $melhor_divisor = $divisor;
            }
          }    
        }
        $potencias_tentadas++;
      }
    }
    if ($menor_diferencial != 0) {
      $maior = $menor + (ceil($diferenca / ($divisor * $potencia)) * ($divisor * $potencia));
    }
	return array ($menor, $maior, $divisor);
  }
  
  function acha_valor($base, $busca_maior, $potencia, $diferenca)
  {
    $direcao_potencia = 0;
    while(TRUE) {
      list ($achou, $resultado) = $this->melhor_com_esta_potencia ($base, $busca_maior, $potencia, $diferenca);
      if ($achou) {
        if (isset($melhor_resultado) &&
          ($melhor_resultado == $resultado)) { 
            break;
        }
        $melhor_resultado = $resultado;  
        if ($direcao_potencia == -1) {
          break;
        }
        $potencia *= 10;
        $direcao_potencia = 1;
      }
      else {
        if ($direcao_potencia == 1) {
          break;
        }
        $potencia /= 10;
        $direcao_potencia = -1;
      }
    }
    return $melhor_resultado;
  }
  
  
  function max_e_min($menor, $maior) 
  {
    if ($menor == $maior) {  
      $menor_escala = $menor;
      $maior_escala = $maior;
      $quantidade_divisoes = 1;
    }
    else { 
      if ($menor > $maior) {
        $temp = $maior;
        $maior = $menor;
        $menor = $temp;
      }    
      $diferenca = $maior - $menor;
      $potencia_inicial = floor(log10($diferenca));
      $potencia_inicial = pow(10, $potencia_inicial);
      $maior_escala = $this->acha_valor($maior, TRUE, $potencia_inicial, $diferenca);
      $menor_escala = $this->acha_valor($menor, FALSE, $potencia_inicial, $diferenca);    
      list ($menor_escala, $maior_escala, $quantidade_divisoes) = $this->divisoes($menor_escala, $maior_escala, $potencia_inicial);
    }
    
    return array ($menor_escala, $maior_escala, $quantidade_divisoes);
  }
	
	
	
}
?>
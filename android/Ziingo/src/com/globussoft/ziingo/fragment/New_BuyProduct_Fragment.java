package com.globussoft.ziingo.fragment;

import java.util.ArrayList;
import java.util.List;

import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.globussoft.ziingo.MainActivity;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.adapter.New_BagAdapter;
import com.globussoft.ziingo.handler.DatabaseHandler;
import com.globussoft.ziingo.imageLoader.ImageLoader;
import com.globussoft.ziingo.model.BagModel;
import com.globussoft.ziingo.utills.Singleton;
import com.globussoft.ziingo.utills.TinyDB;

public class New_BuyProduct_Fragment extends Fragment {
	
	View rootView;
	ImageView thumbNail, plus, minus;
	TextView product_name, product_desc, basic_price, qnt_cnt, total, addToBag,
			subtotal, delivery_charge;

	int i = 1;
	int food_subtotal_amt;
	int food_total_amt;
	
	ImageLoader imageloader;

	// Shared Preferences
	SharedPreferences pref;
	Editor editor;
	int PRIVATE_MODE = 0;
	
	public static DatabaseHandler db;
	
	TinyDB tinydb;
	
	public static List<BagModel> bagModelList_buypr = new ArrayList<BagModel>();
	public static New_BagAdapter bag_Adp_buypr;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		rootView = inflater.inflate(R.layout.buy_food, container, false);
		imageloader = new ImageLoader(getActivity());
		
		((MainActivity)getActivity()).setTitle(Singleton.product_name);
		InitUI();
		return rootView;
	}

	/*protected void sharedPrefernces() {

		pref = this.getActivity().getSharedPreferences(
				"BuyProduct Credentials", PRIVATE_MODE);
		editor = pref.edit();
		editor.putString("foodQuantity", Singleton.product_quantity);
		editor.putString("foodSubTotalAmount", Singleton.product_subtotal);
		editor.putString("foodTotalAmount", Singleton.product_totalAmt);
		editor.putString("foodDeliveryCharge", Singleton.delivery_charge);
		editor.commit();*/
		
		/*New_Bag_Fragment.bagModelList = new ArrayList<BagModel>();
		Singleton.bagListProducts = new HashSet<BagModel>(New_Bag_Fragment.bagModelList);
		
		pref = this.getActivity().getSharedPreferences("Ziingo", PRIVATE_MODE);
		editor = pref.edit();
		editor.putStringSet("bagListProducts", Singleton.bagListProducts);
		editor.commit();
		
	}*/
	
	protected void tinyDB() {	
		
		tinydb.putListObject("product_id_list", Singleton.product_id_list);
		tinydb.putListObject("product_qnty_list", Singleton.product_qnty_list);
		tinydb.putListObject("product_total_list", Singleton.product_total_list);
		
		System.out.println("tinydb >> " + tinydb);
		
		
	}

	private void InitUI() {

		thumbNail    = (ImageView) rootView.findViewById(R.id.buy_food_image);
		product_name = (TextView) rootView.findViewById(R.id.fooditem_name);
		product_desc = (TextView) rootView.findViewById(R.id.food_desc);
		basic_price  = (TextView) rootView.findViewById(R.id.basicprice_amt);
		total        = (TextView) rootView.findViewById(R.id.total);
		plus         = (ImageView) rootView.findViewById(R.id.plus_qnt);
		minus        = (ImageView) rootView.findViewById(R.id.minus_qnt);
		qnt_cnt 	 = (TextView) rootView.findViewById(R.id.qnty_cnt);
		addToBag     = (TextView) rootView.findViewById(R.id.addtobag);
		
		db = new DatabaseHandler(getActivity());
		
		tinydb = new TinyDB(getActivity());
		
		bag_Adp_buypr = new New_BagAdapter(getActivity(), bagModelList_buypr);
	  
		Singleton.previousfragment = "Buy_product";
		Singleton.currentfragment = "Product_List";
		
		qnt_cnt.setText(Integer.toString(i));
		Singleton.product_quantity = qnt_cnt.getText().toString();
		
		//System.out.println("Initial Quantity ====  " + Singleton.product_quantity);

		product_name.setText(Singleton.product_name);
		product_desc.setText(Singleton.product_desc);
		basic_price.setText(Singleton.currency+" "+Singleton.product_basic_price);
		imageloader.DisplayImage(Singleton.product_image, thumbNail);
		total.setText(Singleton.currency+" "+Singleton.product_basic_price);
		
		Singleton.product_totalAmt = Singleton.product_basic_price;

		plus.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				System.out.println(" ++++ Plus Clicked ++++");

				i++;
				qnt_cnt.setText(Integer.toString(i));
				System.out.println("Increased Quantity  ====  "	+ Integer.toString(i));

				Singleton.product_quantity = qnt_cnt.getText().toString();				
				
				food_total_amt = Integer.parseInt(Singleton.product_basic_price) * i;
				Singleton.product_totalAmt = Integer.toString(food_total_amt);
				total.setText(Singleton.currency+" "+Singleton.product_totalAmt);

				//sharedPrefernces();

			}
		});

		minus.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				if (i > 1) {

					i--;
					qnt_cnt.setText(Integer.toString(i));
					System.out.println("Decreased Quantity  ====  " + Integer.toString(i));
					
					Singleton.product_quantity = qnt_cnt.getText().toString();	

					food_total_amt = Integer.parseInt(Singleton.product_basic_price) * i;
					Singleton.product_totalAmt = Integer.toString(food_total_amt);
					total.setText(Singleton.currency+" "+Singleton.product_totalAmt);

					//sharedPrefernces();

				} 
				else 
				{
					Toast.makeText(getActivity(), "Quantity cannot be reduced below one",
							Toast.LENGTH_LONG).show();

				}

			}
		});

		addToBag.setOnClickListener(new OnClickListener() 
		{
			@Override
			public void onClick(View v) 
			{
				// TODO Auto-generated method stub
				
				if((Singleton.product_id_list.contains(Singleton.product_id)) && 
				   (Singleton.product_qnty_list.contains(Singleton.product_quantity) &&
				   (Singleton.product_total_list.contains(Singleton.product_totalAmt))))
				{
					Toast.makeText(getActivity(), "Product already added", Toast.LENGTH_SHORT).show();
				}
				
				else if((Singleton.product_id_list.contains(Singleton.product_id)) && 
					   (!Singleton.product_qnty_list.contains(Singleton.product_quantity) &&
					   (!Singleton.product_total_list.contains(Singleton.product_totalAmt))))
				{					
										
					/**
			         * CRUD Operations
			         * */
			        // Updating products
			        Log.d("Update: ", "Updating .."); 
			        db.updateProduct(new BagModel(Singleton.product_id, Singleton.product_name, Singleton.product_quantity,
			        		                      Singleton.product_totalAmt, Singleton.product_image, ""));        
			        
			        // Reading all products
			        Log.d("Reading: ", "Reading all products.."); 
			        New_Bag_Fragment.bagModelList = db.getAllAddedProducts();			         
			         
			        for (BagModel bm : New_Bag_Fragment.bagModelList) 
			        {
			        	String log = "Product_Id: "+bm.getproduct_id()
			            		+ " ,Product_Name: " + bm.getBag_product_name() 
			            		+ " ,Product_quantity: " + bm.getBag_product_qnt()
			            		+ " ,Product_totalAmt: " + bm.getBag_product_price()
			            		+ " ,Product_image: " + bm.getBag_product_image();
			            
			                // Writing Products to log
			        Log.d("Name: ", log);
			        
			        Singleton.product_qnty_list.set(Singleton.product_id_list.indexOf(bm.getproduct_id()),bm.getBag_product_qnt());
			        Singleton.product_total_list.set(Singleton.product_id_list.indexOf(bm.getproduct_id()),bm.getBag_product_price());
			    }
			        
			    //    MainActivity.mBagCount = db.getProductsCount();
			    //    tinyDB();

				}
								
				else if(!Singleton.product_id_list.contains(Singleton.product_id))                                                                                                                   
				{
					Singleton.product_id_list.add(Singleton.product_id);
					Singleton.product_qnty_list.add(Singleton.product_quantity);
					Singleton.product_total_list.add(Singleton.product_totalAmt);
					
					/**
			         * CRUD Operations
			         * */
			        // Inserting .products
			        Log.d("Insert: ", "Inserting .."); 
			        db.addProduct(new BagModel(Singleton.product_id, Singleton.product_name, Singleton.product_quantity,
			        		Singleton.product_totalAmt, Singleton.product_image, ""));        
			        
			        // Reading all .products
			        Log.d("Reading: ", "Reading all products.."); 
			        New_Bag_Fragment.bagModelList = db.getAllAddedProducts(); 	       
			        
			        
			        for (BagModel bm : New_Bag_Fragment.bagModelList) {
			            String log = "Product_Id: "+bm.getproduct_id()
			            		+ " ,Product_Name: " + bm.getBag_product_name() 
			            		+ " ,Product_quantity: " + bm.getBag_product_qnt()
			            		+ " ,Product_totalAmt: " + bm.getBag_product_price()
			            		+ " ,Product_image: " + bm.getBag_product_image();			            
			           
			                // Writing Products to log
			        Log.d("Name: ", log);	
			        
			       /* Singleton.product_id_list.add(bm.getproduct_id());
			        Singleton.product_qnty_list.add(bm.getBag_product_qnt());
			        Singleton.product_total_list.add(bm.getBag_product_price());	*/		        
			        
			    }			        
			        MainActivity.mBagCount = db.getProductsCount();
			       // tinyDB();
				}	
				
				System.out.println("New_Bag_Fragment.bagModelList :::::: "+ New_Bag_Fragment.bagModelList);
				
				System.out.println("db_cnt :::: "+ db.getProductsCount());
															
				System.out.println("Singleton.product_id_list == "+Singleton.product_id_list);
				System.out.println("Singleton.product_qnty_list == "+Singleton.product_qnty_list);
				System.out.println("Singleton.product_total_list == "+Singleton.product_total_list);
						
				Toast.makeText(getActivity(), "Product added to bag", Toast.LENGTH_SHORT).show();
			
			}
		});

	}	

}
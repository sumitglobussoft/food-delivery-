package com.globussoft.ziingo;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONObject;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.adapter.Edit_del_add_adapter;
import com.globussoft.ziingo.adapter.RestaurantListAdapter;
import com.globussoft.ziingo.model.Edit_del_add_model;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

public class Edit_saved_DeliveryAddress extends Activity {

	public static List<Edit_del_add_model> editModelList = new ArrayList<Edit_del_add_model>();
	private ListView listView;
	private Edit_del_add_adapter adapter;
	TextView save_Add;
	ImageView bk_btn;
	ProgressBar prg;
	
	// Shared Preferences
		public static SharedPreferences pref;
		Editor editor;
		int PRIVATE_MODE = 0;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.edit_del_add_list);
		Initui();
	}
	
	private void sharedPreference()
	{
			pref = getSharedPreferences("Ziingo", MODE_PRIVATE);
			editor = pref.edit();

			editor.putString("delivery_fn", Singleton.delFullname);		
			editor.putString("delivery_ph", Singleton.delPh_num);
			editor.putString("delivery_address", Singleton.delAddress);
			editor.putString("delivery_landmark", Singleton.delLandMark);
			editor.putString("delivery_pincode", Singleton.delpincode);
			editor.putString("order_id", Singleton.order_id);
			//editor.putString("delivery_id", Singleton.delivery_id);

			editor.commit();

			System.out.println("******** Shared Preference ********");
			System.out.println("delivery_address " + Singleton.delAddress);
			System.out.println("order_id " + Singleton.order_id);
			//System.out.println("delivery_id " + Singleton.delivery_id);
			
			System.out.println("******** ******** ******** ********");
		}
		

	private void Initui() 
	{
		prg = (ProgressBar) findViewById(R.id.sel_prg);
		save_Add = (TextView) findViewById(R.id.saveeee);
		bk_btn = (ImageView) findViewById(R.id.delbkbtn);
		
		bk_btn.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				onBackPressed();
			}
		});
		
		save_Add.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				if(Singleton.del_address_ID != null)
				{
					Intent i = new Intent(getApplicationContext(), Edit_Add_deliverAddress.class);
					startActivity(i);
					finish();

				}
				else
				{
					Toast.makeText(getApplicationContext(), "Please select an address.", Toast.LENGTH_SHORT).show();
				}
				
			}
		});
		
		listView = (ListView) findViewById(R.id.list_deladd);
		adapter = new Edit_del_add_adapter(getApplication(), editModelList);
		listView.setAdapter(adapter);

		fetchdeliveryaddress(Singleton.user_id);
		
		listView.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,int position, long id) 
			{
				//view.setSelected(true);	
			
			//	Selected=position;
				
				Singleton.del_address_ID = editModelList.get(position).getDel_address_ID();
				
				System.out.println("user_delivery_address_id >>> "+ Singleton.del_address_ID);
				
				Singleton.delFullname = editModelList.get(position).getDel_userName();
				Singleton.delAddress = editModelList.get(position).getDel_address1();
				Singleton.delLoc = editModelList.get(position).getDel_location();
				Singleton.delCity = editModelList.get(position).getDel_city();
				Singleton.delpincode = editModelList.get(position).getDel_pincode();
				Singleton.Spn_StateName = editModelList.get(position).getDel_state();
				Singleton.delPh_num = editModelList.get(position).getDel_contact_number();
				
				sharedPreference();
				
				
				//editModelList.get(position).isChecked();
				
				
			}
		});

	}

	private void fetchdeliveryaddress(final String user_id) 
	{
		Singleton.delAddress_List.clear();

		editModelList.clear();

		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_fetchdeliveryaddress,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);

							System.out.println("fetch delivery address >>> "+ response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) 
							{
								JSONArray jarr = json.getJSONArray("data");

								for (int j = 0; j < jarr.length(); j++) 
								{
									JSONObject jobj = jarr.getJSONObject(j);

									Edit_del_add_model editmodelList = new Edit_del_add_model();

									editmodelList.setDel_userName(jobj.getString("user_name"));
									editmodelList.setDel_address1(jobj.getString("address_line1"));
									editmodelList.setDel_address2(jobj.getString("address_line2"));
									editmodelList.setDel_city(jobj.getString("district"));
									editmodelList.setDel_pincode(jobj.getString("pin"));
									editmodelList.setDel_landmark(jobj.getString("landmark"));
									editmodelList.setDel_location(jobj.getString("Location"));
									editmodelList.setDel_contact_country_code(jobj.getString("contact_country_code"));
									editmodelList.setDel_contact_number(jobj.getString("contact_number"));
									editmodelList.setDel_state(jobj.getString("state"));
									editmodelList.setDel_country(jobj.getString("country"));
									editmodelList.setDel_address_ID(jobj.getString("user_delivery_address_id"));
									
									editModelList.add(editmodelList);

									// sharedPrefernces();
									
								}
							}

							else {

								Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) 
						{
							e.printStackTrace();
						}
						
						if(editModelList.size() > 0)
						{
							prg.setVisibility(View.INVISIBLE);
						}
						else
						{
							prg.setVisibility(View.VISIBLE);
						}

						adapter.notifyDataSetChanged();

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						// VolleyLog.d(TAG, "Error: " + error.getMessage());
						System.out.println("Error : " + error);
						// hidePDialog();

					}
				}) 
		{

			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("userid", user_id);

				return params;
			}

			@Override
			public Map<String, String> getHeaders() throws AuthFailureError {
				Map<String, String> params = new HashMap<String, String>();
				params.put("Content-Type", "application/x-www-form-urlencoded");
				return params;
			}

		};

		queue.add(sr);

	}

}

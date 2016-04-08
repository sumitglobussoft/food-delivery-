package com.globussoft.ziingo.fragment;

import java.util.HashMap;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONObject;

import android.app.AlertDialog;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.model.OrderStatusModel;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

public class SettingsFragment extends Fragment {

	View rootView;
	AlertDialog alert;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		rootView = inflater.inflate(R.layout.fragment_settings, container,
				false);
		InitUI();
		return rootView;
	}

	private void InitUI() 
	{
		// TODO Auto-generated method stub

		RelativeLayout rel_abt = (RelativeLayout) rootView.findViewById(R.id.rel_abt);
		RelativeLayout rel_chgpass = (RelativeLayout) rootView.findViewById(R.id.rel_chgpass);
		RelativeLayout rel_tc = (RelativeLayout) rootView.findViewById(R.id.rel_tc);
		RelativeLayout rel_pp = (RelativeLayout) rootView.findViewById(R.id.rel_pp);

		rel_abt.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

			}
		});

		rel_chgpass.setOnClickListener(new OnClickListener() 
		{
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub			
			
				showdialog();

			}
		});

		rel_tc.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

			}
		});

		rel_pp.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				/*
				Fragment fragment = new PrivacyPolicy();
				FragmentManager fmanager = getActivity().getSupportFragmentManager();
				FragmentTransaction ftans = fmanager.beginTransaction();
				ftans.replace(R.id.frame_container, fragment);
				ftans.commit();
*/
			}
		});

	}
	
	private void showdialog()
	{
		// TODO Auto-generated method stub

		AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
		LayoutInflater inflater = getActivity().getLayoutInflater();
		
		View convertView = (View) inflater.inflate(R.layout.changepass_dialog, null);			
		
		final EditText old_pass = (EditText) convertView.findViewById(R.id.old_pass);
		final EditText new_pass = (EditText) convertView.findViewById(R.id.new_pass);
		TextView pass_changed = (TextView) convertView.findViewById(R.id.pass_changed);
		ImageView close_btn = (ImageView) convertView.findViewById(R.id.chng_pass_close);
		
		pass_changed.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) 
			{
				// TODO Auto-generated method stub
				
				change_pass(Singleton.user_id, old_pass.getText().toString(), new_pass.getText().toString(), 
						new_pass.getText().toString());
				
			}
		});
		
		close_btn.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) 
			{
				// TODO Auto-generated method stub
			
				alert.dismiss();
				
			}
		});
		
		
		builder.setView(convertView);
		alert = builder.create();
		
		Window window = alert.getWindow();
		WindowManager.LayoutParams lp = window.getAttributes();		
		//lp.copyFrom(window.getAttributes());
		window.setGravity(Gravity.CENTER);

		// This makes the dialog take up the full width

		/*lp.width = WindowManager.LayoutParams.MATCH_PARENT;
		lp.height = WindowManager.LayoutParams.WRAP_CONTENT;
		lp.gravity = Gravity.CENTER;*/
		
		lp.x = 100; // The new position of the X coordinates
        lp.y = 100; // The new position of the Y coordinates
        lp.width = 300; // Width
        lp.height = 100; // Height
       // lp.alpha = 0.7f; // Transparency

		window.setAttributes(lp);
		alert.show();
	}
	
	private void change_pass(final String user_id, final String old_pass, final String new_pass,  final String re_new_pass)
	{
		RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST, ConstantUrl.Url_main + ConstantUrl.Url_changepassword,
				new Response.Listener<String>() 
				{
					@Override
					public void onResponse(String response) 
					{
						try 
						{
							JSONObject json = new JSONObject(response);

							System.out.println("change password response"+ response);

							String msg = json.getString("message");
							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) 
							{
								Toast.makeText(getActivity().getApplication(),"Password successfully changed", Toast.LENGTH_SHORT).show();
								
								alert.dismiss();
							}

							else 
							{
								Toast.makeText(getActivity().getApplication(),msg, Toast.LENGTH_SHORT).show();
							}

						} 
						catch (Exception e)
						{
							e.printStackTrace();
						}

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						// VolleyLog.d(TAG, "Error: " + error.getMessage());
						System.out.println("Error : " + error);

					}
				})
		{
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("user_id", user_id);
				params.put("oldPassword", old_pass);
				params.put("newPassword", new_pass);
				params.put("reNewPassword", re_new_pass);
				
				return params;
			}

		};

		queue.add(sr);
		
	
		
	}

}

package com.globussoft.ziingo.handler;

import java.util.ArrayList;
import java.util.List;

import com.globussoft.ziingo.model.BagModel;
import com.globussoft.ziingo.utills.Singleton;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

public class DatabaseHandler extends SQLiteOpenHelper {
	
	  // All Static variables
    // Database Version
    private static final int DATABASE_VERSION = 1;
 
    // Database Name
    private static final String DATABASE_NAME = "cartProductList";
 
    // Contacts table name
    private static final String TABLE_PRODUCTS = "cartProducts";
 
    // Contacts Table Columns names
    private static final String PRODUCT_ID = "product_id";
    private static final String PRODUCT_NAME = "product_name";
    private static final String PRODUCT_QUANTITY = "product_quantity";    
    private static final String PRODUCT_PRICE = "product_totalAmt";
    private static final String PRODUCT_IMAGE = "product_image";
    private static final String PRODUCT_CARTID = "product_cart_id"; 
    
 
    public DatabaseHandler(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
    }
 
    // Creating Tables
    @Override
    public void onCreate(SQLiteDatabase db) {
        String CREATE_CONTACTS_TABLE = "CREATE TABLE " + TABLE_PRODUCTS + "("
                + PRODUCT_ID + " INTEGER PRIMARY KEY," + PRODUCT_NAME + " TEXT," + PRODUCT_QUANTITY + " INT,"
                + PRODUCT_PRICE + " INT,"+ PRODUCT_IMAGE + " TEXT,"  + PRODUCT_CARTID + " INT" + ")";
        db.execSQL(CREATE_CONTACTS_TABLE);
    }
 
    // Upgrading database
    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        // Drop older table if existed
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_PRODUCTS);
 
        // Create tables again
        onCreate(db);
    }
 
    /**
     * All CRUD(Create, Read, Update, Delete) Operations
     */
 
    // Adding new contact
    public void addProduct(BagModel bagModel) {
        SQLiteDatabase db = this.getWritableDatabase();
 
        ContentValues values = new ContentValues();
        values.put(PRODUCT_ID, bagModel.getproduct_id());
        values.put(PRODUCT_NAME, bagModel.getBag_product_name()); 
        values.put(PRODUCT_QUANTITY, bagModel.getBag_product_qnt()); 
        values.put(PRODUCT_PRICE, bagModel.getBag_product_price()); 
        values.put(PRODUCT_IMAGE, bagModel.getBag_product_image());
        values.put(PRODUCT_CARTID, bagModel.getBag_product_cartid());
 
        // Inserting Row
        db.insert(TABLE_PRODUCTS, null, values);
        db.close(); // Closing database connection
    }
 
    // Getting single product
    public BagModel getProduct(int id) {
        SQLiteDatabase db = this.getReadableDatabase();
 
        Cursor cursor = db.query(TABLE_PRODUCTS, new String[] { PRODUCT_ID,
        		PRODUCT_NAME, PRODUCT_QUANTITY, PRODUCT_PRICE, PRODUCT_IMAGE, PRODUCT_CARTID}, PRODUCT_ID + "=?",
                new String[] { String.valueOf(id) }, null, null, null, null);
        if (cursor != null)
            cursor.moveToFirst();
 
        BagModel bagModel = new BagModel(cursor.getString(0), 
        								 cursor.getString(1), 
        								 cursor.getString(2), 
        								 cursor.getString(3), 
        								 cursor.getString(4),
        								 cursor.getString(5));       
        return bagModel;
    }
    
    // Getting single product id
    public boolean getProductId(String id) {
        SQLiteDatabase db = this.getReadableDatabase();
        
        int count = -1;
        Cursor c = null; 
        try {
           String query = "SELECT COUNT(*) FROM " 
                       + TABLE_PRODUCTS + " WHERE " + PRODUCT_ID + " = ?";
           c = db.rawQuery(query, new String[] {id});
           if (c.moveToFirst()) {
              count = c.getInt(0);
           }
           return count > 0;
        }
        finally {
           if (c != null) {
              c.close();
           }
        }
    }
    
   /* public void addListItem(List<BagModel> listItem) {
        SQLiteDatabase db = this.getWritableDatabase();

        ContentValues values = new ContentValues();
        for (int i = 0; i < listItem.size(); i++) {

            Log.e("vlaue inserting==", "" + listItem.get(i));
            values.put(PRODUCT_ID, listItem.get(i));
            db.insert(TABLE_PRODUCTS, null, values);

        }

        db.close(); // Closing database connection
    }

    Cursor getListItem() {
        String selectQuery = "SELECT  * FROM " + TABLE_PRODUCTS;

        SQLiteDatabase db = this.getWritableDatabase();
        Cursor cursor = db.rawQuery(selectQuery, null);

        return cursor;
    }*/
     
    // Getting All Products
    public List<BagModel> getAllAddedProducts() {
        List<BagModel> bagModelList = new ArrayList<BagModel>();
        // Select All Query
        String selectQuery = "SELECT  * FROM " + TABLE_PRODUCTS;
 
        SQLiteDatabase db = this.getWritableDatabase();
        Cursor cursor = db.rawQuery(selectQuery, null);
 
        // looping through all rows and adding to list
        if (cursor.moveToFirst()) {
            do {
            	BagModel bagModel = new BagModel();
            	bagModel.setproduct_id(cursor.getString(0));
            	bagModel.setBag_product_name(cursor.getString(1));
            	bagModel.setBag_product_qnt(cursor.getString(2));
            	bagModel.setBag_product_price(cursor.getString(3));
            	bagModel.setBag_product_image(cursor.getString(4));
            	bagModel.setBag_product_cartid(cursor.getString(5));
                // Adding contact to list
            	bagModelList.add(bagModel);
            } 
            while (cursor.moveToNext());
        }
 
        // return products list
        return bagModelList;
    }
 
    // Updating single product
    public int updateProduct(BagModel bagModel) {
        SQLiteDatabase db = this.getWritableDatabase();
 
        ContentValues values = new ContentValues();
        values.put(PRODUCT_ID, bagModel.getproduct_id());
        values.put(PRODUCT_NAME, bagModel.getBag_product_name());
        values.put(PRODUCT_QUANTITY, bagModel.getBag_product_qnt());
        values.put(PRODUCT_PRICE, bagModel.getBag_product_price());
        values.put(PRODUCT_IMAGE, bagModel.getBag_product_image());
        values.put(PRODUCT_CARTID, bagModel.getBag_product_cartid());
        // updating row
        return db.update(TABLE_PRODUCTS, values, PRODUCT_ID + " = ?",
                new String[] { String.valueOf(bagModel.getproduct_id()) });
    }
 
    // Deleting single product
    public void deleteProduct(String id ) {
        SQLiteDatabase db = this.getWritableDatabase();
        db.delete(TABLE_PRODUCTS, PRODUCT_ID + " = ?",
                new String[] { String.valueOf(id) });
        db.close();
    } 
    
 // Deleting all products
    public void deleteAll()
    {
    	 SQLiteDatabase db = this.getWritableDatabase();
    	 db.delete(TABLE_PRODUCTS, null, null);   
    	 db.close();
    }
 
    // Getting products Count
    public int getProductsCount() {
    	int count = 0;
        String countQuery = "SELECT  * FROM " + TABLE_PRODUCTS;
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor cursor = db.rawQuery(countQuery, null);
        if(cursor != null && !cursor.isClosed()){
            count = cursor.getCount();
            cursor.close();
        } 
        return count;
    }
    
 

}
